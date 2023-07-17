<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $rolesModel, $userModel;
    public function __construct(Roles $roles, User $user)
    {
        $this->rolesModel = $roles;
        $this->userModel = $user;
    }
    public function index()
    {
        $roles = $this->rolesModel::where('name', '!=' ,'User')->get();
        $rolesCount = $this->rolesModel::count();
        $user = $this->userModel::find(auth()->user()->id);
        return view('Admin.roles.roles' , compact('roles' , 'rolesCount', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'permissions' => 'required|array|min:1',
        ]);

        $this->rolesModel::create([
            'name' => $request->name_ar,
            'permissions' => json_encode($request->permissions),
        ]);

        session()->flash('done', __('dashboard.add_role_message'));
        return back();
    }

    public function edit($id)
    {
        $role = $this->rolesModel::where('id', $id)->first();
        $user = $this->userModel::find(auth()->user()->id);
        return view('Admin.roles.edit-role' , compact('role', 'user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'permissions' => 'required|array|min:1',
            'roleId' => 'required|exists:roles,id'
        ]);
        $role = $this->rolesModel::where('id' , $request->roleId)->first();

        $role->update([
            'name' => $request->name,
            'permissions' => json_encode($request->permissions),
        ]);

        return redirect(route('roles'))->with('done', __('dashboard.update_role_message'));
    }


    public function delete(Request $request)
    {
        $request->validate([
            'roleId' => 'required|exists:roles,id'
        ]);

        $role = $this->rolesModel::where('id' , $request->roleId)->first();

        $role->forcedelete();

        session()->flash('done', __('dashboard.delete_role_message'));
        return back();
    }
}
