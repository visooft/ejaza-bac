<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliavaryDetials;
use App\Models\Packages;
use App\Models\Roles;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    private $packageModel, $userModel, $carbonModel, $settingModel, $walletModel, $roleModel, $deliveryModel;
    public function __construct(Packages $package, User $user, Carbon $carbon, Setting $setting, Wallet $wallet, Roles $role, DeliavaryDetials $delivery)
    {
        $this->packageModel = $package;
        $this->userModel = $user;
        $this->carbonModel = $carbon;
        $this->settingModel = $setting;
        $this->walletModel = $wallet;
        $this->roleModel = $role;
        $this->deliveryModel = $delivery;
    }

    public function packages($status)
    {
        $packages = $this->packageModel::where('status', $status)->orderBy('id', 'DESC')->get();
        foreach ($packages as $package) {
            $date = $this->carbonModel::parse($package->updated_at)->format('Y-m-d');
            $package->date = $date;
        }
        return view('Admin.packages', compact('packages', 'status'));
    }

    public function accepetPackage($id)
    {
        $this->packageModel::where('id', $id)->update([
            'status' => 1,
            'orderStatus' => 'done'
        ]);
        $order = $this->packageModel::where('id', $id)->first();
        $title = __('dashboard.packageNumber') . $order->order_id;
        $message = __('dashboard.approvaeorder');
        PackageController::pushNotification($title, $message, $order->user_id);
        return back()->with('done', __('dashboard.accepetOrderMessage'));
    }
    public function rejecetPackage(Request $request)
    {
        $request->validate([
            'orderId' => 'required|exists:packages,id',
            'reason' => 'required|string',
        ]);
        $this->packageModel::where('id', $request->orderId)->update([
            'status' => 2,
            'orderStatus' => 'wascanceled',
            'cancel_ar' => $request->reason,
            'action_name' => auth()->user()->name
        ]);
        $order = $this->packageModel::where('id', $request->orderId)->first();
        $title = __('dashboard.packageNumber') . $order->order_id;
        $message = __('dashboard.rejecetorder');
        PackageController::pushNotification($title, $message, $order->user_id);
        $user = $this->userModel::find($order->user_id);
        $user->update(['wallet' => $user->wallet + $order->total]);
        if ($order->paymentType == "wallet") {
            $this->walletModel::where(['user_id' => $order->user_id, 'package_id' => $order->id])->update(['type' => 'throwback']);
        } else {
            $walletCount = $this->walletModel::whereDate('created_at', '=', $this->carbonModel::today())->count();
            $year = $this->carbonModel::now()->format('Y');
            $month = $this->carbonModel::now()->format('m');
            $day = $this->carbonModel::now()->format('d');
            $date = $year[2] . $year[3] . $month . $day . (sprintf('%04u', $walletCount + 1));
            $wallet_id = $this->walletModel::where('walletId', $date)->first();
            if ($wallet_id) {
                $date = $date + 1;
            }
            $this->walletModel::create([
                'walletId' => $date,
                'Financial_additions' => $order->total,
                'user_id' => $user->id,
                'package_id' => $order->id,
                'type' => "exports",
            ]);
        }
        return back()->with('done', __('dashboard.rejecetOrderMessage'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'packageId' => 'required|exists:packages,id',
            'reason' => 'required|string'
        ]);
        $this->packageModel::where('id', $request->packageId)->update([
            'status' => 3,
            'orderStatus' => 'wascanceled',
            'cancel_ar' => $request->reason,
            'action_name' => auth()->user()->name
        ]);
        $order = $this->packageModel::where('id', $request->packageId)->first();
        $user = $this->userModel::find($order->user_id);
        $user->update(['wallet' => $user->wallet + $order->total]);
        if ($order->paymentType == "wallet") {
            $this->walletModel::where(['user_id' => $order->user_id, 'package_id' => $order->id])->update(['type' => 'throwback']);
        } else {
            $walletCount = $this->walletModel::whereDate('created_at', '=', $this->carbonModel::today())->count();
            $year = $this->carbonModel::now()->format('Y');
            $month = $this->carbonModel::now()->format('m');
            $day = $this->carbonModel::now()->format('d');
            $date = $year[2] . $year[3] . $month . $day . (sprintf('%04u', $walletCount + 1));
            $wallet_id = $this->walletModel::where('walletId', $date)->first();
            if ($wallet_id) {
                $date = $date + 1;
            }
            $this->walletModel::create([
                'walletId' => $date,
                'Financial_additions' => $order->total,
                'user_id' => $user->id,
                'package_id' => $order->id,
                'type' => "exports",
            ]);
        }
        return back()->with('done', __('dashboard.deleteOrderMessage'));
    }
    public function packageDetials(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:packages,id',
        ]);
        $package = $this->packageModel::find($request->id);
        $data = json_encode($package);
        return $data;
    }

    public function packageData($id)
    {
        $package = $this->packageModel::find($id);
        $date = $this->carbonModel::parse($package->updated_at)->format('Y-m-d');
        $package->date = $date;
        if ($package->delivary_id) {
            $delivary = $this->userModel::find($package->delivary_id);
        } else {
            $delivary = null;
        }
        $delivaryRole = $this->roleModel::where('name', 'Delivary')->first()->id;
        $delivares = $this->userModel::where('role_id', $delivaryRole)->get();
        $delivaresData = [];
        foreach ($delivares as $deliver) {
            $receiveRequest = $this->deliveryModel::where('user_id', $deliver->id)->first()->Receive_requests;
            if ($receiveRequest == 1) {
                array_push($delivaresData, $deliver);
            }
        }
        return view('Admin.users.packageDetials', compact('package', 'delivary', 'delivaresData'));
    }

    public function addDelivary(Request $request)
    {
        $order = $this->packageModel::find($request->package_id);
        $order->update([
            'status' => 1,
            'delivary_id' => $request->delivary_id,
            'accepet' => 1,
        ]);
        $receiveRequest = $this->deliveryModel::where('user_id', $request->delivary_id)->first();
        $receiveRequest->update(['Receive_requests' => 0]);
        $title = __('dashboard.newOrder');
        $message = __('dashboard.Dashboardadd');
        PackageController::pushNotification($title, $message, $request->delivary_id);
        return back()->with('done', __('dashboard.delivaryAddedmessageOrder'));
    }
    public static function pushNotification($title, $message, $user)
    {
        if ($user) {
            $firebaseToken = User::where('id', $user)->whereNotNull('device_token')->pluck('device_token');
            if ($firebaseToken) {
                $setting = Setting::where('key', 'firebaseKey')->first();
                if ($setting) {
                    $SERVER_API_KEY = $setting->value;
                }

                $data = [
                    "registration_ids" => $firebaseToken,
                    "notification" => [
                        "title" => $title,
                        "body" => $message,
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
}
