<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\CacherDetials;
use App\Models\Order;
use App\Models\Roles;
use App\Models\SellerRoles;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CasherController extends Controller
{
    use ImagesTrait;
    private $cacherModel, $shopModel, $CacherDetialsModel, $roleModel, $orderModel, $carbonModel;
    public function __construct(Shop $shop, User $user, CacherDetials $CacherDetials, Roles $role, Order $order, Carbon $carbon)
    {
        $this->cacherModel = $user;
        $this->shopModel = $shop;
        $this->CacherDetialsModel = $CacherDetials;
        $this->roleModel = $role;
        $this->orderModel = $order;
        $this->carbonModel = $carbon;
    }

    public function cacher()
    {
        $data = [];
        $role = $this->roleModel::where('name', 'Casher')->first(['id']);
        $cachers = $this->cacherModel::where('role_id', $role->id)->orderBy('id', 'DESC')->get();
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        foreach ($cachers as $cacher) {
            $shopUser = $this->shopModel::where('user_id', $shop->user_id)->first();
            $CacherDetials = $this->CacherDetialsModel::where('user_id', $cacher->id)->first();
            $shop = $this->shopModel::find($CacherDetials->shop_id);
            if (app()->getLocale() == "ar") {
                $cacher->shopName = $shop->name_ar;
            }
            else {
                $cacher->shopName = $shop->name_en;
            }
            $cacher->shopId = $shop->id;
            if ($shopUser) {
                if ($shopUser->id == $CacherDetials->shop_id) {
                    array_push($data, $cacher);
                }
            }

        }
        return view('Admin.users.cachers', compact('cachers', 'data'));
    }
    public function getProfile ($id)
    {
        $delivery = $this->cacherModel::find($id);
        $details = $this->CacherDetialsModel::where('user_id', $delivery->id)->first();
        $delivery->nationality = $details->nationality;
        $delivery->bankName = $details->bankName;
        $delivery->IPAN = $details->IPAN;
        $delivery->vechiel_type = $details->vechiel_type;
        $delivery->vechiel_plate_number = $details->vechiel_plate_number;
        $newOrders = $this->orderModel::where('cacher_id', $id)->where('orderStatus', '!=', 'deliverd')->count();
        $orderExecuted = $this->orderModel::where('cacher_id', $id)->where('orderStatus', 'deliverd')->count();
        $orders = $this->orderModel::where('cacher_id', $id)->orderBy('id', 'DESC')->get();
        foreach ($orders as $order) {
            $date = $this->carbonModel::parse($order->updated_at)->format('Y-m-d');
            $order->date = $date;
        }
        return view('Admin.users.deliveryProfile', compact('delivery', 'id', 'newOrders', 'orderExecuted', 'orders'));
    }
    public function getStoreCacher($id)
    {
        $cachers = $this->CacherDetialsModel::where('shop_id', $id)->get();
        foreach ($cachers as $cacher) {
            $user = $this->cacherModel::find($cacher->user_id);
            $shop = $this->shopModel::where('id', $id)->first();
            $cacher->cityId = $shop->id;
            if (app()->getLocale() == "ar") {
                $cacher->shopName = $shop->name_ar;
            }
            else {
                $cacher->shopName = $shop->name_en;
            }
            $cacher->name = $user->name;
            $cacher->image = $user->image;
            $cacher->email = $user->email;
            $cacher->phone = $user->phone;
            $cacher->userId = $user->id;
        }
        $shop = $this->shopModel::where('id', $id)->first();
        if (app()->getLocale() == "ar") {
            $shop->name = $shop->name_ar;
        }
        else {
            $shop->name = $shop->name_en;
        }
        return view('Admin.users.shopCacher', compact('cachers', 'shop'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'password' => 'required|string',
            'password_confirmation' => 'required',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $role = $this->roleModel::where('name', 'Casher')->first(['id']);
        if ($request->password != $request->password_confirmation) {
            return back()->with('error', __('dashboard.notConfirmPassword'));
        }
        if ($request->image) {
            $imageName = time()  . '_cacher.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'cachers');
        }
        else {
            $imageName = null;
        }

        $this->cacherModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'image' => $imageName,
            'role_id' => $role->id,
            'status' => 1,
        ]);
        $cacher = $this->cacherModel::orderBy('id', 'DESC')->first();
        if (auth()->user()->seller_roles) {
            $sellerRole = SellerRoles::where('id', auth()->user()->seller_roles)->first()->shop_id;
            $shop = Shop::find($sellerRole);
        }
        else
        {
            $shop = $this->shopModel::where('user_id', auth()->user()->id)->first();
        }
        $this->CacherDetialsModel::create([
            'user_id' => $cacher->id,
            'shop_id' => $shop->id,
        ]);
        return back()->with('done', __('dashboard.addCacherSuccessMessage'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email,'.$request->userId,
            'phone' => 'required|numeric|digits:10|unique:users,phone,'.$request->userId,
            'password' => 'nullable|string',
            'password_confirmation' => 'nullable',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        $admin = $this->cacherModel::find($request->userId);
        if ($request->image) {
            if ($admin->image) {
                $imageName = time()  . '_cacher.' . $request->image->extension();
                $oldImagePath = 'Admin/images/cachers/' . $admin->image;

                $this->uploadImage($request->image, $imageName, 'cachers', $oldImagePath);
            }
            else {
                $imageName = time()  . '_cacher.' . $request->image->extension();
                $this->uploadImage($request->image, $imageName, 'cachers');
            }
        }
        else {
            $imageName = $admin->image;
        }
        if ($request->password) {
            $password = bcrypt($request->password);
        }
        else {
            $password = $admin->password;
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'image' => $imageName,
        ]);
        return back()->with('message', __('dashboard.updateCacherSuccess'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
        ]);

        $admin = $this->cacherModel::find($request->userId);
        if ($admin->image) {
            $imageUrl = "Admin/images/cachers/" . $admin->image;
            unlink(public_path($imageUrl));
        }
        $admin->forcedelete();

        return back()->with('done', __('dashboard.delteCacherSuccess'));
    }
}
