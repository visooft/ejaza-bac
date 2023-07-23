<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment as PaymentModel;

class Payment extends Controller
{
    public function index()
    {
        try {
            $pay = PaymentModel::all();
            return response()->json([
                'status' => true,
                'message' => 'تم جلب البيانات بنجاح',
                'data' => $pay
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ ما',
                'data' => $e->getMessage()
            ]);
        }
    }

    public function post()
    {
        try {
            $pay = new PaymentModel();
            $pay->name = request()->name;
            $pay->status = request()->status;
            $pay->type = request()->type;
            $images = array();
            if ($files = request()->image) {
                foreach ($files as $file) {
                    $image_name = md5(rand(100, 200));
                    $ext = strtolower($file->getClientOriginalExtension());
                    $image_full_name = $image_name . '.' . $ext;
                    $upload_path = 'images/payments/';
                    $image_url = $upload_path . $image_full_name;
                    $file->move($upload_path, $image_full_name);
                    $images[] = $image_url;
                }
            }
            $pay->image = $images;
            $pay->save();
            return response()->json([
                'status' => true,
                'message' => 'تم اضافة البيانات بنجاح',
                'data' => $pay
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ ما',
                'data' => $e->getMessage()
            ]);
        }
    }
}
