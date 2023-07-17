<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerRoles;
use App\Models\Shop;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    private $sizeModel, $shopModel;
    public function __construct(Size $size, Shop $shop)
    {
        $this->sizeModel = $size;
        $this->shopModel = $shop;
    }

    public function size()
    {
        $data = [];
        $sizes = $this->sizeModel::orderBy('id', 'DESC')->get();
        foreach ($sizes as $size) {
            if (auth()->user()->seller_roles) {
                $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
                $shop = Shop::find($sellerRole);
            }
            else
            {
                $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
            }
            $shopUser = $this->shopModel::where('user_id', $shop->user_id)->first();
            if (app()->getLocale() == "ar") {
                $size->name = $size->name_ar;
                $size->shopName = $shop->name_ar;
            }
            else {
                $size->name = $size->name_en;
                $size->shopName = $shop->name_en;
            }
            if ($size->shop_id == $shopUser->id) {
                array_push($data, $size);
            }
        }
        return view('Admin.size', compact('sizes', 'data', 'shop'));
    }
    public function store (Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string'
        ]);
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        $this->sizeModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'shop_id' => $shop->id
        ]);

        return back()->with('done', __('dashboard.addSizeMessage'));
    }

    public function update (Request $request)
    {
        $request->validate([
            'sizeId' => 'required|exists:sizes,id',
            'name_ar' => 'required|string',
            'name_en' => 'required|string'
        ]);
        $size = $this->sizeModel::find($request->sizeId);
        $size->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en
        ]);

        return back()->with('done', __('dashboard.updateSizeMessage'));
    }
    public function delete (Request $request)
    {
        $request->validate([
            'sizeId' => 'required|exists:sizes,id',
        ]);
        $size = $this->sizeModel::find($request->sizeId);
        $size->delete();

        return back()->with('done', __('dashboard.deleteSizeMessage'));
    }
}
