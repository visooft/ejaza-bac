<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImagesTrait;
use App\Models\Country;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ImagesTrait;
    private $userModel, $roleModel, $countryModel;
    public function __construct(User $user, Roles $role, Country $country)
    {
        $this->userModel = $user;
        $this->roleModel = $role;
        $this->countryModel = $country;
    }

    public function embloyee()
    {
        $user = $this->roleModel::where('name', 'User')->first()->id;
        $admin = $this->roleModel::where('name', 'super Admin')->first()->id;
        $embloyees = $this->userModel::where('id', '<>', auth()->user()->id)->where('role_id', '!=', $user)->where('role_id', '!=', $admin)->orderBy('id', 'DESC')->get();
        foreach ($embloyees as $employee) {
            if (app()->getLocale() == "tr") {
                $employee->country = $this->countryModel::where('id', $employee->country_id)->first()->name_tr;
            } elseif (app()->getLocale() == "en") {
                $employee->country = $this->countryModel::where('id', $employee->country_id)->first()->name_en;
            } else {
                $employee->country = $this->countryModel::where('id', $employee->country_id)->first()->name_ar;
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
        $roles = $this->roleModel::where('name', '!=', 'User')->where('name', '!=', 'super Admin')->get();
        return view('Admin.users.embloyees', compact('embloyees', 'roles', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'password' => 'required|string',
            'password_confirmation' => 'required',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        if ($request->password != $request->password_confirmation) {
            return back()->with('error', __('dashboard.notConfirmPassword'));
        }
        if ($request->image) {
            $imageName = time()  . '_employee.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'employees');
        } else {
            $imageName = null;
        }

        $this->userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'image' => $imageName,
            'role_id' => $request->role_id,
            'country_id' => $request->country_id,
            'link' => "https://visooft-code.com",
            'status' => 1,
        ]);

        return back()->with('done', __('dashboard.addEmployeeSuccess'));
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
            'role_id' => 'required|exists:roles,id',
            'country_id' => 'required|exists:countries,id',
        ]);
        $admin = $this->userModel::find($request->userId);
        if ($request->image) {
            if ($admin->image) {
                $imageName = time()  . '_employee.' . $request->image->extension();
                $oldImagePath = 'Admin/images/employees/' . $admin->image;

                $this->uploadImage($request->image, $imageName, 'employees', $oldImagePath);
            } else {
                $imageName = time()  . '_employee.' . $request->image->extension();
                $this->uploadImage($request->image, $imageName, 'employees');
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
            'role_id' => $request->role_id,
        ]);
        return back()->with('message', __('dashboard.updateEmployeeSuccess'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'userId' => 'required|exists:users,id',
        ]);

        $admin = $this->userModel::find($request->userId);
        if ($admin->image) {
            $imageUrl = "Admin/images/employees/" . $admin->image;
            unlink(public_path($imageUrl));
        }
        $admin->forcedelete();

        return back()->with('done', __('dashboard.delteEmployeeSuccess'));
    }
}
