<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupons;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $couponModel, $shopModel, $carbonModel, $categoryModel;

    public function __construct(Coupons $coupon, Carbon $carbon, Category $category)
    {
        $this->couponModel = $coupon;
        $this->carbonModel = $carbon;
        $this->categoryModel = $category;
    }

    public function coupon()
    {
        $couponsExpired = [];
        $couponsLive = [];
        $coupons = $this->couponModel::orderBy('id', 'DESC')->get();

        foreach ($coupons as $coupon) {
            $couponOne = $this->couponModel::find($coupon->id);

            $date1 = strtotime(date($coupon->end));
            $date2 = strtotime(date("Y-m-d"));

            if ($date1 >= $date2) {
                $date = 0;
            }
            else {
                $date = 1;
            }
            if ($couponOne->counUsed == $coupon->count || $date) {
                array_push($couponsExpired, $coupon);
            }
            else {
                array_push($couponsLive, $coupon);
            }
        }

        return view('Admin.coupons', compact('couponsExpired', 'couponsLive'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupon' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'countuse' => 'required|numeric',
            'percentage' => 'nullable|numeric',
            'typeOffer' => 'required|in:percentage,valueDiscount',
        ]);

        if ($request->typeOffer == "percentage") {
            $offer = $request->percentage;
            $type = "percentage";
        }
        
        $this->couponModel::create([
            'coupon' => $request->coupon,
            'start' => $request->start,
            'end' => $request->end,
            'count' => $request->countuse,
            'offer' => $offer,
            'type' => $type,
            'firstCountInput' => $request->firstCountInput,
        ]);

        session()->flash('done', __('dashboard.addCouponMessage'));
        return redirect()->route('coupon');
    }

    public function addCoupon()
    {
        
        return view('Admin.addCoupon');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'couponId' => 'required|exists:coupons,id'
        ]);
        $this->couponModel::where('id', $request->couponId)->delete();
        return back()->with('done', __('dashboard.deleteCouponMessage'));
    }
}
