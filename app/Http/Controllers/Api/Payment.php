<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment as PaymentModel;
use Translate;

class Payment extends Controller
{
    public function index()
    {
        try {
            $pay = PaymentModel::where('status', 1)->get();
            foreach ($pay as $p) {
                $p->name = Translate::trans($p->name);
            }
            foreach ($pay as $p) {
                $images = array();
                foreach ($p->image as $image) {
                    $images[] = asset($image);
                }
                $p->image = $images;
            }

            return response()->json([
                'status' => true,
                'message' => __('api.successMessage'),
                'data' => $pay,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('api.errorMessage'),
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
                'message' => __('api.successMessage'),
                'data' => $pay
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('api.errorMessage'),
                'data' => $e->getMessage()
            ]);
        }
    }
}
