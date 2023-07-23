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
}
