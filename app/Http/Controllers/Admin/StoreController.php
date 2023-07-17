<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Http\Traits\StoreTraits;
use App\Models\Category;
use App\Models\Menue;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopDetials;
use App\Models\ShopSub;
use App\Models\Size;
use Illuminate\Support\Facades\Mail;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use ImagesTrait, StoreTraits;
    private $userModel, $storeModel, $productModel, $shopSubModel, $subCategoryModel, $categoryModel, $shopDetialsModel, $menueModel, $sizeModel, $orderModel, $mailModel;
    public function __construct(Product $product, User $user, Shop $shop, ShopSub $shopSub, SubCategory $subCategory, Category $category, ShopDetials $shopDetials, Menue $menue, Size $size, Order $order, Mail $mail)
    {
        $this->userModel = $user;
        $this->storeModel = $shop;
        $this->productModel = $product;
        $this->shopSubModel = $shopSub;
        $this->subCategoryModel = $subCategory;
        $this->categoryModel = $category;
        $this->shopDetialsModel = $shopDetials;
        $this->menueModel = $menue;
        $this->sizeModel = $size;
        $this->orderModel = $order;
        $this->mailModel = $mail;
    }

    public function stores($status)
    {
        $stores = $this->getStores($status);
        $categories = $this->categoryModel::where('status', 1)->get();
        foreach ($categories as $category) {
            if (app()->getLocale() == "ar") {
                $category->name = $category->name_ar;
            }
            else {
                $category->name = $category->name_en;
            }
        }
        return view('Admin.stores.stores', compact('stores', 'categories', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|min:5|max:200',
            'name_en' => 'required|string|min:5|max:200',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'phone' => 'required|exists:users,phone',
            'logo' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048',
            'backGround' => 'required|file|mimes:jpeg,jpg,png,gif|max:2048',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'delivaryCost' => 'required|numeric',
            'time' => 'required|numeric',
            'address' => 'required|string',
            'link' => 'nullable|url',
            'storePhone' => 'required|unique:shop_detials,phone|digits:10',
            'categoryId' => 'required|exists:categories,id',
        ]);

        $imageName = time()  . '_shop.' . $request->logo->extension();
        $this->uploadImage($request->logo, $imageName, 'shop');

        $backGround = random_int(0,99999999)  . '_shop.' . $request->backGround->extension();
        $this->uploadImage($request->backGround, $backGround, 'shop');
        $user = $this->userModel::where('phone', $request->phone)->first();

        $this->storeModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'logo' => $imageName,
            'backGround' => $backGround,
            'category_id' => $request->categoryId,
            'user_id' => $user->id
        ]);
        $store = $this->storeModel::orderBy('id', 'DESC')->first();

        $this->shopDetialsModel::create([
            'time' => $request->time,
            'delivaryCost' => $request->delivaryCost,
            'lat' => $request->lat,
            'long' => $request->long,
            'address' => $request->address,
            'link' => $request->link,
            'phone' => $request->phone,
            'shop_id' => $store->id
        ]);
        $this->menueModel::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'shop_id' => $store->id,
            'status' => 1
        ]);
        return back()->with('done', __('dashboard.addStoreSuccess'));
    }

    public function accepetStore($id)
    {
        $this->storeModel::where('id', $id)->update(['status' => 1]);
        $user = $this->storeModel::where('id', $id)->first()->user_id;
        $this->userModel::where('id', $user)->update(['status' => 1]);
        $user = $this->userModel::where('id', $user)->first();
        $title = __('web.accepetTitleStore');
        $this->mailModel::send('Admin.emails.accapetAds',['title' => $title], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject(__('web.accepetTitleStore'));
        });
        return back()->with('done', __('dashboard.accepetStoreMessage'));
    }

    public function rejecetStore($id)
    {
        $this->storeModel::where('id', $id)->update(['status' => 2]);
        $user = $this->storeModel::where('id', $id)->first()->user_id;
        $this->userModel::where('id', $user)->update(['status' => 0]);
        $title = __('web.rejecetTitleStore');
        $this->mailModel::send('Admin.emails.accapetAds',['title' => $title], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject(__('web.rejecetTitleStore'));
        });
        return back()->with('done', __('dashboard.rejecetStroeMessage'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'storeId' => 'required|exists:shops,id',
            'categoryId' => 'required|exists:categories,id',
            'name_ar' => 'required|string|min:5|max:200',
            'name_en' => 'required|string|min:5|max:200',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'phone' => 'required|exists:users,phone',
            'logo' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'backGround' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'delivaryCost' => 'required|numeric',
            'time' => 'required|numeric',
            'address' => 'required|string',
            'link' => 'nullable|url',
            'storePhone' => 'required|digits:10',
        ]);
        $store = $this->storeModel::find($request->storeId);
        if ($request->logo) {
            $imageName = time()  . '_shop.' . $request->logo->extension();
            $oldImagePath = 'Admin/images/shop/' . $store->logo;

            $this->uploadImage($request->logo, $imageName, 'shop', $oldImagePath);
        }
        else {
            $imageName = $store->logo;
        }
        if ($request->backGround) {
            $backGround = random_int(0,99999999)  . '_shop.' . $request->backGround->extension();
            $oldImagePath = 'Admin/images/shop/' . $store->backGround;

            $this->uploadImage($request->backGround, $backGround, 'shop', $oldImagePath);
        }
        else {
            $backGround = $store->backGround;
        }
        $user = $this->userModel::where('phone', $request->phone)->first();
        $store->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'logo' => $imageName,
            'backGround' => $backGround,
            'user_id' => $user->id,
            'category_id' => $request->categoryId
        ]);

        $detials = $this->shopDetialsModel::where('shop_id', $request->storeId)->first();
        $detials->update([
            'time' => $request->time,
            'delivaryCost' => $request->delivaryCost,
            'lat' => $request->lat,
            'long' => $request->long,
            'address' => $request->address,
            'link' => $request->link,
            'phone' => $request->phone,
            'shop_id' => $store->id
        ]);

        return back()->with('done',  __('dashboard.updateStoreSuccess'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'storeId' => 'required|exists:shops,id',
        ]);
        $store = $this->storeModel::find($request->storeId);
        if ($store->logo) {
            $imageUrl = "Admin/images/shop/" . $store->logo;
            unlink(public_path($imageUrl));
        }
        if ($store->backGround) {
            $imageUrl = "Admin/images/shop/" . $store->backGround;
            unlink(public_path($imageUrl));
        }
        $this->sizeModel::where('shop_id', $store->id)->delete();
        $this->orderModel::where('seller_id', $store->user_id)->delete();
        $store->forcedelete();

        return back()->with('done', __('dashboard.delteStoreMessage'));
    }
    public function hideStore(Request $request)
    {
        $request->validate([
            'storeId' => 'required|exists:shops,id',
        ]);

        $store = $this->storeModel::find($request->storeId);
        $store->update([
            'hide' => 1,
            'show' => 0
        ]);
        return back()->with('done', __('dashboard.hideStoreMessage'));
    }
    public function showStore(Request $request)
    {
        $request->validate([
            'storeId' => 'required|exists:shops,id',
        ]);

        $store = $this->storeModel::find($request->storeId);
        $store->update([
            'hide' => 0,
            'show' => 1
        ]);
        return back()->with('done', __('dashboard.showStoreMessage'));
    }
}
