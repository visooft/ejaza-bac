<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menue;
use App\Models\Shop;
use Illuminate\Http\Request;

class MenueController extends Controller
{
    private $menueModel, $shopModel, $categoryModel;
    public function __construct(Menue $menue, Shop $shop, Category $category)
    {
        $this->menueModel = $menue;
        $this->shopModel = $shop;
        $this->categoryModel = $category;
    }

    public function menues()
    {
        $menues = [];
        $category = $this->categoryModel::where('name_en', 'Resturant')->first();
        $shops = $this->shopModel::where('category_id', $category->id)->get();
        foreach ($shops as $shop) {
            $menue = $this->menueModel::where('shop_id', $shop->id)->first();
            if ($menue) {
                if (app()->getLocale() == "ar") {
                    $menue->shopName = $shop->name_ar;
                    $menue->name = $menue->name_ar;
                }
                else {
                    $menue->shopName = $shop->name_en;
                    $menue->name = $menue->name_en;
                }
                array_push($menues, $menue);
            }
        }
        foreach ($shops as $shop) {
            if (app()->getLocale() == "ar") {
                $shop->name = $shop->name_ar;
            }
            else {
                $shop->name = $shop->name_en;
            }
        }

        return view('Admin.menues', compact('shops', 'menues'));
    }

    public function menueStore()
    {
        $menues = [];
        $category = $this->categoryModel::where('name_en', 'Resturant')->first();
        $shops = $this->shopModel::where('category_id', '!=' , $category->id)->get();
        foreach ($shops as $shop) {
            $menue = $this->menueModel::where('shop_id', $shop->id)->first();
            if ($menue) {
                if (app()->getLocale() == "ar") {
                    $menue->shopName = $shop->name_ar;
                    $menue->name = $menue->name_ar;
                }
                else {
                    $menue->shopName = $shop->name_en;
                    $menue->name = $menue->name_en;
                }
                array_push($menues, $menue);
            }
        }
        foreach ($shops as $shop) {
            if (app()->getLocale() == "ar") {
                $shop->name = $shop->name_ar;
            }
            else {
                $shop->name = $shop->name_en;
            }
        }
        return view('Admin.menues', compact('shops', 'menues'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'shop_id' => 'required|exists:shops,id'
        ]);

        $shop = $this->menueModel::where('shop_id', $request->shop_id)->first();
        if ($shop) {
            return back()->with('error', __('dashboard.errorSubmit'));
        }
        $this->menueModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'shop_id' => $request->shop_id,
        ]);
        return back()->with('done', __('dashboard.addMenueSuccess'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:3|max:200',
            'name_en' => 'required|string|min:3|max:200',
            'shop_id' => 'required|exists:shops,id',
            'menueId' => 'required|exists:menues,id',
        ]);
        $menue = $this->menueModel::find($request->menueId);
        if ($menue->shop_id == $request->shop_id) {
            $menue->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
            ]);
        }
        else {
            $shop = $this->menueModel::where('shop_id', $request->shop_id)->first();
            if ($shop) {
                return back()->with('error', __('dashboard.errorSubmit'));
            }
            $menue->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'shop_id' => $request->shop_id,
            ]);
        }

        return back()->with('done', __('dashboard.updateMenueSuccess'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'menueId' => 'required|exists:menues,id'
        ]);
        $menue = $this->menueModel::find($request->menueId);
        $menue->delete();
        return back()->with('done', __('dashboard.deleteMenueSuccess'));
    }
    public function show(Request $request)
    {
        $request->validate([
            'menueId' => 'required|exists:menues,id'
        ]);
        $menue = $this->menueModel::find($request->menueId);
        $menue->update([
            'status' => 1
        ]);
        return back()->with('done', __('dashboard.showMenueSuccess'));
    }
    public function hide(Request $request)
    {
        $request->validate([
            'menueId' => 'required|exists:menues,id'
        ]);
        $menue = $this->menueModel::find($request->menueId);
        $menue->update([
            'status' => 0
        ]);
        return back()->with('done', __('dashboard.hideMenueSuccess'));
    }
}
