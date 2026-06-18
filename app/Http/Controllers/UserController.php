<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    public function edit(string $id)
    {
        $user = User::with('roles', 'permissions')->findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all()->groupBy('module');
        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'تم تحديث صلاحيات المستخدم بنجاح!');
    }
}
