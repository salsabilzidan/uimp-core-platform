<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\SubsystemController;
use App\Http\Controllers\AuditController;

/*
|--------------------------------------------------------------------------
| Web Routes - UIMP Core Platform
|--------------------------------------------------------------------------
*/

// [1] مسارات الضيوف (يمنع دخول المسجلين إليها)
Route::middleware('guest')->group(function () {
    Route::get('/', function () { return redirect()->route('login'); });
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// [2] مسار تسجيل الخروج (يجب أن يكون متاحاً دائماً للمسجلين)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// [3] المسارات المحمية أمنياً (مستحيل دخولها بدون تسجيل دخول فعلي ومؤكد)
Route::middleware(['auth', 'verified'])->group(function () {

    // لوحة التحكم الرئيسية
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== إدارة المستخدمين والصلاحيات =====
    Route::prefix('users')->name('users.')->middleware('role:sys_admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
    });

    // ===== API Documentation =====
    Route::get('/api-docs', function () { return view('api-docs'); })->name('api.docs');

    // ===== Faculties =====
    Route::get('/faculties', [FacultyController::class, 'index'])->name('faculties.index')->middleware('permission:faculties.view');
    Route::get('/faculties/create', [FacultyController::class, 'create'])->name('faculties.create')->middleware('role:sys_admin');
    Route::post('/faculties', [FacultyController::class, 'store'])->name('faculties.store')->middleware('role:sys_admin');
    Route::get('/faculties/{id}', [FacultyController::class, 'show'])->name('faculties.show')->middleware('permission:faculties.view');
    Route::get('/faculties/{id}/edit', [FacultyController::class, 'edit'])->name('faculties.edit')->middleware('role:sys_admin');
    Route::put('/faculties/{id}', [FacultyController::class, 'update'])->name('faculties.update')->middleware('role:sys_admin');
    Route::delete('/faculties/{id}', [FacultyController::class, 'destroy'])->name('faculties.destroy')->middleware('role:sys_admin');

    // ===== Departments =====
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index')->middleware('permission:departments.view');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create')->middleware('role:sys_admin');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store')->middleware('role:sys_admin');
    Route::get('/departments/{id}', [DepartmentController::class, 'show'])->name('departments.show')->middleware('permission:departments.view');
    Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit')->middleware('role:sys_admin');
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update')->middleware('role:sys_admin');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy')->middleware('role:sys_admin');

    // ===== Employees =====
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index')->middleware('permission:employees.view');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create')->middleware('role:sys_admin');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store')->middleware('role:sys_admin');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show')->middleware('permission:employees.view');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit')->middleware('role:sys_admin');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update')->middleware('role:sys_admin');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy')->middleware('role:sys_admin');

    // ===== Students =====
    Route::get('/students', [StudentController::class, 'index'])->name('students.index')->middleware('permission:students.view');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create')->middleware('role:sys_admin');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store')->middleware('role:sys_admin');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show')->middleware('permission:students.view');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit')->middleware('role:sys_admin');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update')->middleware('role:sys_admin');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('role:sys_admin');

    // ===== Campuses =====
    Route::get('/campuses', [CampusController::class, 'index'])->name('campuses.index')->middleware('permission:campuses.view');
    Route::get('/campuses/create', [CampusController::class, 'create'])->name('campuses.create')->middleware('role:sys_admin');
    Route::post('/campuses', [CampusController::class, 'store'])->name('campuses.store')->middleware('role:sys_admin');
    Route::get('/campuses/{id}', [CampusController::class, 'show'])->name('campuses.show')->middleware('permission:campuses.view');
    Route::get('/campuses/{id}/edit', [CampusController::class, 'edit'])->name('campuses.edit')->middleware('role:sys_admin');
    Route::put('/campuses/{id}', [CampusController::class, 'update'])->name('campuses.update')->middleware('role:sys_admin');
    Route::delete('/campuses/{id}', [CampusController::class, 'destroy'])->name('campuses.destroy')->middleware('role:sys_admin');

    // ===== Buildings =====
    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index')->middleware('permission:buildings.view');
    Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create')->middleware('role:sys_admin');
    Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store')->middleware('role:sys_admin');
    Route::get('/buildings/{id}', [BuildingController::class, 'show'])->name('buildings.show')->middleware('permission:buildings.view');
    Route::get('/buildings/{id}/edit', [BuildingController::class, 'edit'])->name('buildings.edit')->middleware('role:sys_admin');
    Route::put('/buildings/{id}', [BuildingController::class, 'update'])->name('buildings.update')->middleware('role:sys_admin');
    Route::delete('/buildings/{id}', [BuildingController::class, 'destroy'])->name('buildings.destroy')->middleware('role:sys_admin');

    // ===== Rooms =====
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index')->middleware('permission:rooms.view');
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create')->middleware('role:sys_admin');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store')->middleware('role:sys_admin');
    Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show')->middleware('permission:rooms.view');
    Route::get('/rooms/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit')->middleware('role:sys_admin');
    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update')->middleware('role:sys_admin');
    Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy')->middleware('role:sys_admin');

    // ===== Laboratories =====
    Route::get('/laboratories', [LaboratoryController::class, 'index'])->name('laboratories.index')->middleware('permission:laboratories.view');
    Route::get('/laboratories/create', [LaboratoryController::class, 'create'])->name('laboratories.create')->middleware('role:sys_admin');
    Route::post('/laboratories', [LaboratoryController::class, 'store'])->name('laboratories.store')->middleware('role:sys_admin');
    Route::get('/laboratories/{id}', [LaboratoryController::class, 'show'])->name('laboratories.show')->middleware('permission:laboratories.view');
    Route::get('/laboratories/{id}/edit', [LaboratoryController::class, 'edit'])->name('laboratories.edit')->middleware('role:sys_admin');
    Route::put('/laboratories/{id}', [LaboratoryController::class, 'update'])->name('laboratories.update')->middleware('role:sys_admin');
    Route::delete('/laboratories/{id}', [LaboratoryController::class, 'destroy'])->name('laboratories.destroy')->middleware('role:sys_admin');

    // ===== Subsystems Registry =====
    Route::get('/subsystems', [SubsystemController::class, 'index'])->name('subsystems.index')->middleware('permission:subsystems.view');
    Route::get('/subsystems/create', [SubsystemController::class, 'create'])->name('subsystems.create')->middleware('role:sys_admin');
    Route::post('/subsystems', [SubsystemController::class, 'store'])->name('subsystems.store')->middleware('role:sys_admin');
    Route::get('/subsystems/{id}', [SubsystemController::class, 'show'])->name('subsystems.show')->middleware('permission:subsystems.view');
    Route::get('/subsystems/{id}/edit', [SubsystemController::class, 'edit'])->name('subsystems.edit')->middleware('role:sys_admin');
    Route::put('/subsystems/{id}', [SubsystemController::class, 'update'])->name('subsystems.update')->middleware('role:sys_admin');
    Route::delete('/subsystems/{id}', [SubsystemController::class, 'destroy'])->name('subsystems.destroy')->middleware('role:sys_admin');
    Route::post('/subsystems/{id}/regenerate-key', [SubsystemController::class, 'regenerateKey'])->name('subsystems.regenerate-key')->middleware('role:sys_admin');

    // ===== Audit Logs =====
    Route::get('/audit-logs', [AuditController::class, 'index'])->name('audit-logs.index')->middleware('permission:audit-logs.view');
    Route::get('/audit-logs/{id}', [AuditController::class, 'show'])->name('audit-logs.show')->middleware('permission:audit-logs.view');
});