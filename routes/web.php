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
    return "
        <div style='text-align: center; margin-top: 100px; font-family: Cairo, sans-serif; direction: rtl;'>
            <h1 style='color: #1e3d59;'>مرحباً بكِ في لوحة التحكم المركزية لمنصة UIMP!</h1>
            <p style='color: #666;'>لقد نجحتِ في تسجيل الدخول إلى النظام بأمان.</p>
            <br>
            <form action='".route('logout')."' method='POST'>
                <input type='hidden' name='_token' value='".csrf_token()."'>
                <button type='submit' style='background-color: #ff4d4d; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;'>تسجيل الخروج</button>
            </form>
        </div>
    ";
})->middleware('auth')->name('dashboard');