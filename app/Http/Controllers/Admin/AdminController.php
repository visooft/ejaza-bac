<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Roles;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use ImagesTrait;
    private $userModel, $roleModel, $cityModel, $carbonModel, $categoryModel, $subCategoryModel, $contactModel, $bdModel, $countryModel;
    public function __construct(User $user, Roles $role, Carbon $carbon, City $city, Category $category, SubCategory $subCategory, Contact $contact, DB $db, Country $country)
    {
        $this->userModel = $user;
        $this->roleModel = $role;
        $this->carbonModel = $carbon;
        $this->cityModel = $city;
        $this->subCategoryModel = $subCategory;
        $this->categoryModel = $category;
        $this->contactModel = $contact;
        $this->bdModel = $db;
        $this->countryModel = $country;
    }
    public function index()
    {
        return view('Admin.index');
    }
    public function superAdmin()
    {
        $role = $this->roleModel::where('name', 'super Admin')->first(['id']);
        $admins = $this->userModel::where('id', '<>', auth()->user()->id)->where('role_id', $role->id)->orderBy('id', 'DESC')->get();
        foreach ($admins as $admin) {
            if (app()->getLocale() == "tr") {
                $admin->country = $this->countryModel::where('id', $admin->country_id)->first()->name_tr;
            } elseif (app()->getLocale() == "en") {
                $admin->country = $this->countryModel::where('id', $admin->country_id)->first()->name_en;
            } else {
                $admin->country = $this->countryModel::where('id', $admin->country_id)->first()->name_ar;
            }
        }
        $roleId = $role->id;
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
        return view('Admin.users.admins', compact('admins', 'roleId', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'roleId' => 'required|exists:roles,id',
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'country_id' => 'required|exists:countries,id',
            'password' => 'required|string',
            'password_confirmation' => 'required',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        if ($request->password != $request->password_confirmation) {
            return back()->with('error', __('dashboard.notConfirmPassword'));
        }
        if ($request->image) {
            $imageName = time() . '_admin.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'admins');
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
        ]);

        return back()->with('done', __('dashboard.addAdminSuccess'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email,' . $request->userId,
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . $request->userId,
            'password' => 'nullable|string',
            'password_confirmation' => 'nullable',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'country_id' => 'required|exists:countries,id',
        ]);
        $admin = $this->userModel::find($request->userId);
        if ($request->image) {
            if ($admin->image) {
                $imageName = time() . '_admin.' . $request->image->extension();
                $oldImagePath = 'Admin/images/admins/' . $admin->image;

                $this->uploadImage($request->image, $imageName, 'admins', $oldImagePath);
            } else {
                $imageName = time() . '_admin.' . $request->image->extension();
                $this->uploadImage($request->image, $imageName, 'admins');
            }
        } else {
            $imageName = $admin->image;
        }
        if ($request->password) {
            $password = bcrypt($request->password);
        } else {
            $password = $admin->password;
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'image' => $imageName,
            'country_id' => $request->country_id,
        ]);
        return back()->with('message', __('dashboard.updateAdminSuccess'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
        ]);

        $admin = $this->userModel::find($request->userId);
        if ($admin->image) {
            $imageUrl = "Admin/images/admins/" . $admin->image;
            unlink(public_path($imageUrl));
        }
        $admin->forcedelete();

        return back()->with('done', __('dashboard.delteAdminSuccess'));
    }

    public function unBlock($id)
    {
        $user = $this->userModel::find($id);
        if (!$user) {
            return back();
        }
        $user->update([
            'status' => 1
        ]);

        return back()->with('done', __('dashboard.unblockUser'));
    }
}
