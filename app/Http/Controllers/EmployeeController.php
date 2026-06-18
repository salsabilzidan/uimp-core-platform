<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use App\Services\EventBusService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['user', 'department'])->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $permissions = \App\Models\Permission::all()->groupBy('module');
        return view('employees.create', compact('departments', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'password'      => 'required|string|min:8',
            'department_id' => 'required|exists:departments,id',
            'employee_code' => 'required|string|max:50|unique:employees,employee_code',
            'phone'         => 'required|string|max:20',
            'role'          => 'required|exists:roles,id',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        Employee::create([
            'user_id'       => $user->id,
            'department_id' => $request->department_id,
            'employee_code' => $request->employee_code,
            'phone'         => $request->phone,
        ]);

        $user->roles()->attach($request->role);

        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }

        app(NotificationService::class)->send([
            'type' => 'email',
            'channel' => 'mail',
            'recipient' => $user->email,
            'subject' => 'بيانات حسابك في النظام الجامعي UIMP',
            'body' => "مرحباً {$user->name}،\n\nتم إنشاء حسابك الوظيفي في النظام الجامعي.\nالبريد الإلكتروني: {$user->email}\n\nشكراً لانضمامك.",
        ]);

        app(EventBusService::class)->dispatch('employee.created', [
            'employee_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'تم إنشاء حساب الموظف وإضافته للنظام بنجاح!');
    }

    public function show(string $id)
    {
        $employee = Employee::with(['user', 'department'])->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit(string $id)
    {
        $employee = Employee::with('user', 'user.roles', 'user.permissions')->findOrFail($id);
        $departments = Department::all();
        $permissions = \App\Models\Permission::all()->groupBy('module');
        $roles = \App\Models\Role::all();
        return view('employees.edit', compact('employee', 'departments', 'permissions', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'        => 'nullable|string|min:8',
            'department_id'   => 'required|exists:departments,id',
            'employee_code'   => 'required|string|max:50|unique:employees,employee_code,' . $employee->id,
            'phone'           => 'required|string|max:20',
            'role'            => 'required|exists:roles,id',
            'permissions'     => 'nullable|array',
            'permissions.*'   => 'exists:permissions,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $employee->department_id = $request->department_id;
        $employee->employee_code = $request->employee_code;
        $employee->phone = $request->phone;
        $employee->save();

        $user->roles()->sync([$request->role]);

        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        } else {
            $user->permissions()->detach();
        }

        app(EventBusService::class)->dispatch('employee.updated', [
            'employee_id' => $employee->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف بنجاح!');
    }

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $user = $employee->user;
        $employeeId = $employee->id;
        $userId = $user->id;
        $employee->delete();
        if ($user) {
            $user->delete();
        }

        app(EventBusService::class)->dispatch('employee.deleted', [
            'employee_id' => $employeeId,
            'user_id' => $userId,
        ]);

        return redirect()->route('employees.index')->with('success', 'تم حذف حساب الموظف بالكامل من النظام!');
    }
}
