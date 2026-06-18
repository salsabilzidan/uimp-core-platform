<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // عرض صفحة تسجيل الدخول مع فحص قاعدة البيانات
    public function showLogin() {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return view('auth.login')->withErrors(['email' => 'قاعدة البيانات غير متصلة. الرجاء تشغيل MySQL والتأكد من إعدادات الاتصال.']);
        }
        return view('auth.login');
    }

    // معالجة عملية تسجيل الدخول باستخدام البريد الإلكتروني
    public function login(Request $request) {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->onlyInput('email');
    }

    // تسجيل الخروج الآمن وتدمير الجلسة بالكامل
    public function logout(Request $request) {
        Auth::logout();
        
        // تدمير الجلسة تماماً لكي لا يتذكر المتصفح الدخول تلقائياً
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}