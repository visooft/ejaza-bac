<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Category;
use App\Models\Country;
use App\Models\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    use ImagesTrait;

    private $userModel, $adverticeModel, $roleModel, $cityModel, $carbonModel, $orderModel, $categoryModel, $shopModel, $countryModel;

    public function __construct(User $user, Roles $role, Carbon $carbon, Category $category, Country $country)
    {
        $this->userModel = $user;
        $this->roleModel = $role;
        $this->carbonModel = $carbon;
        $this->categoryModel = $category;
        $this->countryModel = $country;
    }

    public function users()
    {
        $role = $this->roleModel::where('name', 'User')->first(['id']);
        $users = $this->userModel::where('role_id', $role->id)->orderBy('id', 'DESC')->get();
        foreach ($users as $user) {
            if (app()->getLocale() == "tr") {
                $user->country = $this->countryModel::where('id', $user->country_id)->first()->name_tr;
            } elseif (app()->getLocale() == "en") {
                $user->country = $this->countryModel::where('id', $user->country_id)->first()->name_en;
            } else {
                $user->country = $this->countryModel::where('id', $user->country_id)->first()->name_ar;
            }
        }
        $countries = $this->countryModel::where('status', 1)->get();
        foreach ($countries as $country) {
            if (app()->getLocale() == "tr") {
                $country->name = $country->name_tr;
            } elseif (app()->getLocale() == "en") {
                $country->name = $country->name_en;
            } else {
                $country->name = $country->name_ar;
            }
        }
        $roleId = $role->id;
        return view('Admin.users.users', compact('users', 'roleId', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'roleId' => 'required|exists:roles,id',
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'country_id' => 'required|exists:countries,id',
            'password' => [
                'required',
                'string',
                'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'password_confirmation' => 'required',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        if ($request->image) {
            $imageName = time() . '_user.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'users');
        } else {
            $imageName = null;
        }

        $this->userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'image' => $imageName,
            'role_id' => $request->roleId,
            'country_id' => $request->country_id,
            'link' => "https://visooft-code.com",
            'status' => 1,
            'documentation' => '0',
        ]);

        return back()->with('message', __('dashboard.addMemberSuccess'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'name' => 'required|string|min:3|max:190',
            'email' => 'required|email|unique:users,email,' . $request->userId,
            'phone' => 'required|numeric|unique:users,phone,' . $request->userId,
            'country_id' => 'required|exists:countries,id',
            'password' => [
                'nullable',
                'string',
                'confirmed', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'password_confirmation' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
        $user = $this->userModel::find($request->userId);
        if ($request->image) {
            if ($user->image) {
                $imageName = time() . '_user.' . $request->image->extension();
                $oldImagePath = 'Admin/images/users/' . $user->image;

                $this->uploadImage($request->image, $imageName, 'users', $oldImagePath);
            } else {
                $imageName = time() . '_user.' . $request->image->extension();
                $this->uploadImage($request->image, $imageName, 'users');
            }
        } else {
            $imageName = $user->image;
        }
        if ($request->password) {
            $password = bcrypt($request->password);
        } else {
            $password = $user->password;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'image' => $imageName,
            'country_id' => $request->country_id,
        ]);
        return back()->with('message', __('dashboard.updateMemberSuccess'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
        ]);

        $user = $this->userModel::find($request->userId);
        if ($user->image) {
            $imageUrl = "Admin/images/users/" . $user->image;
            unlink(public_path($imageUrl));
        }
        $user->forcedelete();

        return back()->with('done', __('dashboard.delteMemberSuccess'));
    }

    public function Accountverification($id)
    {
        $user = $this->userModel::find($id);
        if (!$user) {
            return back();
        }
        $user->update([
            'status' => 1
        ]);
        Mail::send('Admin.emails.email', compact('user'), function ($message) use ($user) {
            $message->to($user->email);
            $message->subject(__('dashboard.AccepeteAccountverification'));
        });
        return back()->with('done', __('dashboard.AccepeteAccountverification'));
    }

    public function Accountdocumentation($id)
    {
        $user = $this->userModel::find($id);
        if (!$user) {
            return back();
        }
        $user->update([
            'documentation' => !$user->documentation ? 1 : 0
        ]);
        return back()->with('done', __('dashboard.AccepeteAccountdocumentation'));
    }

    public function Accountdeclined($id)
    {
        $user = $this->userModel::find($id);
        if (!$user) {
            return back();
        }
        $user->update([
            'status' => 2
        ]);
        return back()->with('done', __('dashboard.rejectAccountverification'));
    }

    public function block($id)
    {
        $user = $this->userModel::find($id);
        if (!$user) {
            return back();
        }
        $user->update([
            'status' => 3
        ]);
        return back()->with('done', __('dashboard.blockUser'));
    }

    public function getprofile($id)
    {
        $user = $this->userModel::find($id);
        // $newOrders = $this->orderModel::where('user_id', $id)->where('orderStatus', '!=', 'deliverd')->count();
        // $orderExecuted = $this->orderModel::where('user_id', $id)->where('orderStatus', 'deliverd')->count();
        // $orders = $this->orderModel::where('user_id', $id)->orderBy('id', 'DESC')->get();
        // foreach ($orders as $order) {
        //     $date = $this->carbonModel::parse($order->updated_at)->format('Y-m-d');
        //     $order->date = $date;
        // }
        $newOrders = 0;
        $orderExecuted = 0;
        $orders = [];
        return view('Admin.users.userProfile', compact('user', 'id', 'newOrders', 'orderExecuted', 'orders'));
    }

    public function categoryBuy($id)
    {
        $data = [];

        $orders = $this->orderModel::where(['user_id' => $id, 'status' => 1, 'orderStatus' => 'deliverd'])->distinct('seller_id')->get(['seller_id']);
        foreach ($orders as $key => $order) {
            $countData = $this->orderModel::where(['user_id' => $id, 'status' => 1, 'seller_id' => $order->seller_id, 'orderStatus' => 'deliverd'])->count();
            $shop = $this->shopModel::where('user_id', $order->seller_id)->first();
            $order->categoryid = $shop->category->id;
            $order->countData = $countData;
            if (count($data) > 0) {
                if ($order->categoryid == $data[$key - 1]["categoryid"]) {
                    $data[$key - 1]["countData"] += $countData;
                    unset($orders[$key]);
                }
            } else {
                array_push($data, $order);
            }
        }
        $categories = $this->categoryModel::orderBy('id', 'DESC')->get();
        foreach ($categories as $key => $category) {
            if (app()->getLocale() == "ar") {
                $category->name = $category->name_ar;
            } else {
                $category->nam = $category->name_en;
            }
            $category->image = env('APP_URL') . "Admin/images/category/" . $category->image;
            if ($orders[count($orders) - 1]->categoryid == $category->id) {
                $category->countData = $orders[count($orders) - 1]->countData;
            } else {
                $category->countData = 0;
            }
        }

        return view('Admin.users.categoryBuy', compact('categories', 'orders'));
    }
}
