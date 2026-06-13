<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\College;
use App\Models\Department;
use App\Models\Employee; // قمت بإضافة هذا السطر لاستخدامه في الـ Dashboard
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\DB; // استدعاء مكتبة الـ DB للتأكد من عمل الـ count

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// المسار الرئيسي للموقع
Route::get('/', function () {
    return redirect()->route('login');
});

// مسارات نظام تسجيل الدخول (Authentication)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// مسار لوحة التحكم المركزية (محمي)
Route::get('/dashboard', function () {
    // جلب أعداد السجلات الحقيقية من قاعدة البيانات باستخدام الموديلات
    $collegesCount = College::count();
    $departmentsCount = Department::count();
    $employeesCount = Employee::count(); // الآن نستخدم الموديل مباشرة

    // تمرير الأرقام لصفحة الـ Dashboard
    return view('dashboard', compact('collegesCount', 'departmentsCount', 'employeesCount'));
})->middleware('auth')->name('dashboard');

// الموارد (Resources)
Route::resource('faculties', FacultyController::class)->middleware('auth');
Route::resource('departments', DepartmentController::class)->middleware('auth');
Route::resource('employees', EmployeeController::class)->middleware('auth');