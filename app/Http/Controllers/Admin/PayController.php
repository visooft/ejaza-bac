<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('Admin.payment', compact('payments'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:payments,name,' . $request->payId,
            'image' => 'nullable|array',
        ]);
        Payment::find($request->payId)->update([
            'name' => $request->name,
        ]);
        $images = array();
        if ($files = $request->file('image')) {
            $old_image = Payment::find($request->payId)->image;
            foreach ($old_image as $image) {
                unlink($image);
            }
            foreach ($files as $file) {
                $image_name = md5(rand(100, 200));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'images/payments/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $image_full_name);
                $images[] = $image_url;
            }
            Payment::find($request->payId)->update([
                'image' => $images,
            ]);
        }

        return back()->with('done', 'تم تعديل طريقة الدفع بنجاح');
    }

    public function hide(Request $request)
    {
        $year = Payment::find($request->payId);
        $year->update([
            'status' => 0
        ]);
        return back()->with('done', 'تم اخفاء طريقة الدفع بنجاح');
    }

    public function show(Request $request)
    {
        $year = Payment::find($request->payId);
        $year->update([
            'status' => 1
        ]);
        return back()->with('done', 'تم اظهار طريقة الدفع بنجاح');
    }
}
