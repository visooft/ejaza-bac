<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CityTrait;
use App\Http\Traits\ImagesTrait;
use App\Models\Comments;
use App\Models\Images;
use App\Models\Order;
use App\Models\Roles;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DelivaryController extends Controller
{
    use ImagesTrait, CityTrait;
    private $userModel, $roleModel, $deliveryModel, $cityModel, $OrderDetialsModel, $cacherDetialsModel, $shopModel, $orderModel, $carbonModel, $colorDataModel, $shopDetialsModel, $settingModel, $commenetModel;
    public function __construct(User $user, Roles $role, Order $orderData, Carbon $carbon, Setting $setting, Comments $commenet)
    {
        $this->userModel = $user;
        $this->roleModel = $role;
        $this->orderModel = $orderData;
        $this->carbonModel = $carbon;
        $this->settingModel = $setting;
        $this->commenetModel = $commenet;
    }


    public function orderDetials($id)
    {
        $order = Order::find($id);
        $order->image = Images::where('housings_id', $order->housings_id)->first()->image;
        return view('Admin.users.orderDetials', compact('order'));
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
?>
