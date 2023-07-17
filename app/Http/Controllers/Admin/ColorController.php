<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\ColorData;
use App\Models\SellerRoles;
use App\Models\Shop;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    private $colorModel, $shopModel, $colorDataModel;
    public function __construct(Color $color, Shop $shop, ColorData $colorData)
    {
        $this->colorModel = $color;
        $this->shopModel = $shop;
        $this->colorDataModel = $colorData;
    }

    public function colors()
    {
        $data = [];
        $colors = $this->colorModel::orderBy('id', 'DESC')->get();
        $colorData = $this->colorDataModel::get();
        foreach ($colors as $color) {
            $colorDetials = $this->colorDataModel::find($color->color_id);
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
                $color->shopName = $shop->name_ar;
            }
            else {
                $color->shopName = $shop->name_en;
            }
            $color->name = $colorDetials->name;
            $color->code = $colorDetials->code;
            if ($color->shop_id == $shopUser->id) {
                array_push($data, $color);
            }
            elseif (auth()->user()->role->name == "super Admin" || auth()->user()->role->name == "Employee") {
                array_push($data, $color);
            }
        }
        return view('Admin.colors', compact('colors', 'colorData', 'data'));
    }
    public function store (Request $request)
    {
        $request->validate([
            'colorId' => 'required|exists:color_data,id',
        ]);
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        $this->colorModel::create([
            'color_id' => $request->colorId,
            'shop_id' => $shop->id
        ]);

        return back()->with('done', __('dashboard.addcolorMessage'));
    }

    public function update (Request $request)
    {
        $request->validate([
            'colorDataId' => 'required|exists:color_data,id',
            'colorId' => 'required|exists:colors,id',
        ]);
        $color = $this->colorModel::find($request->colorId);
        $color->update([
            'color_id' => $request->colorDataId,
        ]);

        return back()->with('done', __('dashboard.updatecolorMessage'));
    }
    public function delete (Request $request)
    {
        $request->validate([
            'colorId' => 'required|exists:colors,id',
        ]);
        $color = $this->colorModel::find($request->colorId);
        $color->delete();

        return back()->with('done', __('dashboard.deletecolorMessage'));
    }
}
