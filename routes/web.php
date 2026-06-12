<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| هنا يتم تسجيل جميع مسارات الويب الخاصة بالنظام.
|
*/

// المسار الرئيسي للموقع (يحول تلقائياً إلى صفحة تسجيل الدخول)
Route::get('/', function () {
    return redirect()->route('login');
});

// مسارات نظام تسجيل الدخول (Authentication)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// مسار لوحة التحكم المركزية (محمي: لا يمكن دخوله إلا بعد تسجيل الدخول)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');