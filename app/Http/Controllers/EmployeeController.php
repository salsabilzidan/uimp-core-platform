<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; 
use App\Models\Department;
use App\Http\Controllers\Controller;    
use App\Models\User;       
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {// جلب الموظفين مع بياناتهم من جدول المستخدمين والأقسام
    $employees = Employee::with(['user', 'department'])->get();

    return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all(); // جلب كل الأقسام ليعرضها في القائمة المنسدلة
    return view('employees.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|string|email|max:255|unique:users,email',
        'password'        => 'required|string|min:8',
        'department_id'   => 'required|exists:departments,id',
        'employee_code'   => 'required|string|max:50|unique:employees,employee_code',
        'phone'           => 'required|string|max:20',
    ]);

    // أولاً: إنشاء الحساب في جدول الـ users الأساسي
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password), // تشفير كلمة المرور للحماية
    ]);

    // ثانياً: أخذ الـ ID الخاص بالمستخدم الجديد وتخزين باقي البيانات في جدول الموظفين
    Employee::create([
        'user_id'       => $user->id, // الربط التلقائي
        'department_id' => $request->department_id,
        'employee_code' => $request->employee_code,
        'phone'         => $request->phone,
    ]);

    return redirect()->route('employees.index')->with('success', 'تم إنشاء حساب الموظف وإضافته للنظام بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::with('user')->findOrFail($id);
    $departments = Department::all(); // لجلب الأقسام لغرض الاختيار منها
    return view('employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
    $user = $employee->user;

    // التحقق من البيانات مع استثناء الحساب الحالي من شروط الـ Unique
    $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password'        => 'nullable|string|min:8', // nullable تعني اختياري
        'department_id'   => 'required|exists:departments,id',
        'employee_code'   => 'required|string|max:50|unique:employees,employee_code,' . $employee->id,
        'phone'           => 'required|string|max:20',
    ]);

    // تحديث بيانات جدول الـ users
    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password); // يتغير فقط لو كتب المستخدم باسورد جديد
    }
    $user->save();

    // تحديث بيانات جدول الـ employees
    $employee->department_id = $request->department_id;
    $employee->employee_code = $request->employee_code;
    $employee->phone = $request->phone;
    $employee->save();

    return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
    $user = $employee->user;

    // حذف الموظف أولاً ثم حساب المستخدم الخاص به
    $employee->delete();
    if ($user) {
        $user->delete();
    }

    return redirect()->route('employees.index')->with('success', 'تم حذف حساب الموظف بالكامل من النظام!');
    }
}
