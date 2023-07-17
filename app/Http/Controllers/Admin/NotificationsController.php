<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notifications;
use App\Models\NotificationsDetials;
use App\Models\Roles;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationsController extends Controller
{
    private $notificationsModel, $userModel, $notificationsDetialsModel, $categoryModel, $roleModel, $shopModel;
    public function __construct(Notifications $notifications, User $user, NotificationsDetials $notificationsDetials, Category $category, Roles $role)
    {
        $this->notificationsModel = $notifications;
        $this->userModel = $user;
        $this->roleModel = $role;
        $this->categoryModel = $category;
        $this->notificationsDetialsModel = $notificationsDetials;
    }

    public function notifications()
    {
        $notifications = $this->notificationsModel::orderBy('id', 'DESC')->get();
        return view('Admin.notifications', compact('notifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:50|min:3',
            'message' => 'required|string|max:200|min:3',
            'phone' => 'nullable|exists:users,phone',
            'allUser' => 'nullable',
            'email' => 'nullable',
            'appNotifications' => 'nullable',
        ]);
        $category = $this->categoryModel::where('name_en', 'Resturant')->first();
        if ($request->allUser) {
            $users = $this->userModel::where(['status' => 1])->get();
            if ($request->email && $request->appNotifications) {
                foreach ($users as $user) {
                    NotificationsController::sendEmail($request, $user);
                    NotificationsController::pushNotification($request, $user->id);
                }
            } elseif ($request->email) {
                foreach ($users as $user) {
                    NotificationsController::sendEmail($request, $user);
                }
            } elseif ($request->appNotifications) {
                foreach ($users as $user) {
                    NotificationsController::pushNotification($request, $user->id);
                }
            }
            $this->notificationsModel::create([
                'subject' => $request->subject,
                'message' => $request->message,
                'all' => 1,
            ]);
            $notification = $this->notificationsModel::orderBy('id', 'DESC')->first();
            foreach ($users as $user) {
                $this->notificationsDetialsModel::create([
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                ]);
            }
        } else {

            $user = $this->userModel::where('phone', $request->phone)->where('status', 1)->first();
            if ($user) {
                $userId = $user->id;
            } else {
                $userId = null;
            }
            if ($request->email) {
                NotificationsController::sendEmail($request, $user);
            } elseif ($request->appNotifications) {
                NotificationsController::pushNotification($request, $user->id);
            }
            $this->notificationsModel::create([
                'subject' => $request->subject,
                'message' => $request->message,
                'user_id' => $userId,
            ]);
        }

        return back()->with('done', __('dashboard.sendNotification'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'notificationId' => 'required|exists:notifications,id'
        ]);
        $notification = $this->notificationsModel::find($request->notificationId);
        $notification->delete();
        return back()->with('done', __('dashboard.deleteNotificationMessage'));
    }
    public function getData(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $user = $this->userModel::find($request->user_id);
        $data = json_encode($user);
        return $data;
    }

    public static function sendEmail(Request $request, $user)
    {
        $messageData = $request->message;
        $subjectData = $request->subject;

        $mailFrom = Setting::where('key', 'MAIL_FROM_ADDRESS')->first();
        $MAIL_USERNAME = Setting::where('key', 'MAIL_USERNAME')->first();
        $MAIL_PASSWORD = Setting::where('key', 'MAIL_PASSWORD')->first();
        $MAIL_FROM_ADDRESS = Setting::where('key', 'MAIL_FROM_ADDRESS')->first();
        $MAIL_HOST = Setting::where('key', 'MAIL_HOST')->first();

        config('mail.from.address', $MAIL_FROM_ADDRESS->value);
        config('mail.mailers.smtp.password', $MAIL_PASSWORD->value);
        config('mail.mailers.smtp.username', $MAIL_USERNAME->value);
        config('mail.mailers.smtp.host', $MAIL_HOST->value);

        Mail::send('Admin.emails.email', compact('user', 'messageData', 'subjectData'), function ($message) use ($request, $user, $mailFrom) {
            $message->to($user->email);
            $message->subject($request->subject);
        });
    }

    public static function pushNotification(Request $request, $user)
    {
        if ($user) {
            $firebaseToken = User::where('id', $user)->whereNotNull('device_token')->pluck('device_token');
            $setting = Setting::where('key', 'firebaseKey')->first();
            if ($setting) {
                $SERVER_API_KEY = $setting->value;
            }

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => $request->subject,
                    "body" => $request->message,
                ]
            ];

            $dataString = json_encode($data);
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($ch);
        }
    }
}
