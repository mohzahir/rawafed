<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // معالجة بيانات تسجيل الدخول
    public function login(Request $request)
    {
        // 1. التحقق من صحة المدخلات
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. محاولة تسجيل الدخول
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // تجديد الجلسة لحماية التطبيق
            $request->session()->regenerate();

            // توجيه المدير إلى لوحة التحكم بعد نجاح الدخول
            return redirect()->intended('/admin/dashboard');
        }

        // 3. في حال فشل الدخول، إرجاع المستخدم مع رسالة خطأ
        return back()->withErrors([
            'email' => 'البيانات المدخلة لا تتطابق مع سجلاتنا.',
        ])->onlyInput('email');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}