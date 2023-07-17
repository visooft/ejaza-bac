<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Additions;
use App\Models\AdditionsDetials;
use App\Models\SellerRoles;
use App\Models\Shop;
use Illuminate\Http\Request;

class AddtionsController extends Controller
{
    private $additionModel, $shopModel, $additionsDetialsModel;

    public function __construct(Shop $shop, Additions $additions, AdditionsDetials $additionsDetials)
    {
        $this->additionModel = $additions;
        $this->shopModel = $shop;
        $this->additionsDetialsModel = $additionsDetials;
    }

    public function addtions()
    {
        $data = [];
        $additions = $this->additionModel::orderBy('id', 'DESC')->get();
        foreach ($additions as $addition) {
            $shop = $this->shopModel::find($addition->shop_id);
            if (auth()->user()->seller_roles) {
                $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
                $shopUser = Shop::find($sellerRole);
            } else {
                $shopUser = $this->shopModel::where('user_id', auth()->user()->id)->first();
            }
            if (app()->getLocale() == "ar") {
                $addition->name = $addition->name_ar;
                $addition->shopName = $shop->name_ar;
            } else {
                $addition->name = $addition->name_en;
                $addition->shopName = $shop->name_en;
            }
            if ($addition->shop_id == $shopUser->id) {
                array_push($data, $addition);
            }
        }
        return view('Admin.additions', compact('additions', 'data'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string'
        ]);
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        } else {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        $this->additionModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'shop_id' => $shop->id
        ]);

        return back()->with('done', __('dashboard.addAdditionsMessage'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'additionId' => 'required|exists:additions,id',
            'name_ar' => 'required|string',
            'name_en' => 'required|string'
        ]);
        $addition = $this->additionModel::find($request->additionId);
        $addition->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en
        ]);

        return back()->with('done', __('dashboard.updateAdditionMessage'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'additionId' => 'required|exists:additions,id',
        ]);
        $addition = $this->additionModel::find($request->additionId);
        $addition->delete();

        return back()->with('done', __('dashboard.deleteAdditionsMessage'));
    }
    public function addtionsDetials($id)
    {
        $additions = $this->additionsDetialsModel::where('addition_id', $id)->get();
        foreach ($additions as $addition) {
            if (app()->getLocale() == "ar") {
                $addition->name = $addition->name_ar;
            } else {
                $addition->name = $addition->name_en;
            }
        }
        return view('Admin.additionsDetials', compact('additions', 'id'));
    }
    public function storeAddition(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'additionId' => 'required|exists:additions,id'
        ]);
        $this->additionsDetialsModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'addition_id' => $request->additionId
        ]);

        return back()->with('done', __('dashboard.addAdditionsMessage'));
    }

    public function updateAddition(Request $request)
    {
        $request->validate([
            'additionId' => 'required|exists:additions_detials,id',
            'name_ar' => 'required|string',
            'name_en' => 'required|string'
        ]);
        $addition = $this->additionsDetialsModel::find($request->additionId);
        $addition->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en
        ]);

        return back()->with('done', __('dashboard.updateAdditionMessage'));
    }
    public function deleteAddition(Request $request)
    {
        $request->validate([
            'additionId' => 'required|exists:additions_detials,id',
        ]);
        $addition = $this->additionsDetialsModel::find($request->additionId);
        $addition->delete();

        return back()->with('done', __('dashboard.deleteAdditionsMessage'));
    }
}
