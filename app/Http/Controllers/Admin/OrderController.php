<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\Images;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderModel, $userModel, $productModel, $sizeModel, $carbonModel, $walletModel;
    public function __construct(Order $order, User $user, Housing $product, Carbon $carbon, Wallet $wallet)
    {
        $this->orderModel = $order;
        $this->userModel = $user;
        $this->productModel = $product;
        $this->carbonModel = $carbon;
        $this->walletModel = $wallet;
    }

    public function orders($status)
    {
        $orders = $this->orderModel::where('status', $status)->orderBy('id', 'DESC')->paginate(10);
        foreach ($orders as $order) {
            $order->image = env('APP_URL') . 'Admin/images/ads/'.Images::where('housings_id', $order->housings_id)->first()->image;
            $date = $this->carbonModel::parse($order->updated_at)->format('Y-m-d');
            $order->date = $date;
        }
        return view('Admin.orders', compact('orders', 'status'));
    }

    public function accepetOrder($id)
    {
        $this->orderModel::where('id', $id)->update([
            'status' => 1,
        ]);
        $order = $this->orderModel::where('id', $id)->first();
        $title = __('dashboard.orderNumber') . $order->order_id;
        $message = __('dashboard.approvaeorder');
        OrderController::pushNotification($title, $message, $order->user_id);
        return back()->with('done', __('dashboard.accepetOrderMessage'));
    }
    public function rejecetOrder(Request $request)
    {
        $request->validate([
            'orderId' => 'required|exists:orders,id',
            'reason' => 'required|string',
        ]);
        $this->orderModel::where('id', $request->orderId)->update([
            'status' => 2,
            'cancel_ar' => $request->reason,
            'action_name' => auth()->user()->name
        ]);
        $order = $this->orderModel::where('id', $request->orderId)->first();
        $title = __('dashboard.orderNumber') . $order->order_id;
        $message = __('dashboard.rejecetorder');
        OrderController::pushNotification($title, $message, $order->user_id);
        // $user = $this->userModel::find($order->user_id);
        // $user->update(['wallet' => $user->wallet + $order->totalpayment]);
        // if ($order->paymentType == "wallet") {
        //     $this->walletModel::where(['user_id' => $order->user_id, 'order_id' => $order->id])->update(['type' => 'throwback']);
        // } else {
        //     $walletCount = $this->walletModel::whereDate('created_at', '=', $this->carbonModel::today())->count();
        //     $year = $this->carbonModel::now()->format('Y');
        //     $month = $this->carbonModel::now()->format('m');
        //     $day = $this->carbonModel::now()->format('d');
        //     $date = $year[2] . $year[3] . $month . $day . (sprintf('%04u', $walletCount + 1));
        //     $wallet_id = $this->walletModel::where('walletId', $date)->first();
        //     if ($wallet_id) {
        //         $date = $date + 1;
        //     }
        //     $this->walletModel::create([
        //         'walletId' => $date,
        //         'Financial_additions' => $order->totalpayment,
        //         'user_id' => $user->id,
        //         'order_id' => $order->id,
        //         'type' => "exports",
        //     ]);
        // }
        return back()->with('done', __('dashboard.rejecetOrderMessage'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'orderId' => 'required|exists:orders,id',
            'reason' => 'required|string',
        ]);
        $this->orderModel::where('id', $request->orderId)->update([
            'status' => 3,
            'orderStatus' => 'wascanceled',
            'cancel_ar' => $request->reason,
            'action_name' => auth()->user()->name
        ]);
        $order = $this->orderModel::where('id', $request->orderId)->first();
        $title = __('dashboard.orderNumber') . $order->order_id;
        $message = __('dashboard.rejecetorder');
        OrderController::pushNotification($title, $message, $order->user_id);
        $user = $this->userModel::find($order->user_id);
        $user->update(['wallet' => $user->wallet + $order->totalpayment]);
        if ($order->paymentType == "wallet") {
            $this->walletModel::where(['user_id' => $order->user_id, 'order_id' => $order->id])->update(['type' => 'throwback']);
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
                'Financial_additions' => $order->totalpayment,
                'user_id' => $user->id,
                'order_id' => $order->id,
                'type' => "exports",
            ]);
        }
        return back()->with('done', __('dashboard.deleteOrderMessage'));
    }
    public static function pushNotification($title, $message, $user)
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
