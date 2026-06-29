<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PhoneVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PhoneVerificationController extends Controller
{
    // ========== نمایش فرم‌ها ==========

    // صفحه تأیید شماره بعد از ثبت‌نام
    public function showForm()
    {
        return view('auth.verify-phone');
    }

    // ========== ثبت‌نام ==========

    // تأیید شماره برای ثبت‌نام جدید 
   public function verifyPhone(Request $request)
{
    $request->validate(['phone' => 'required|string|size:11']);

    $user = Auth::user();
    $user->mobile = $request->phone;
    $user->phone_verified_at = now();
    $user->save();

    $dashboardRoute = $user->role === 'charity' ? 'charity.dashboard' : 'donor.dashboard';

    return response()->json([
        'success' => true,
        'redirect' => route($dashboardRoute)
    ]);
}

    // ========== بازیابی رمز ==========

    // تأیید شماره برای بازیابی رمز 
    public function verifyForReset(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|size:11',
        ]);

        $user = User::where('mobile', $request->phone)->first();
            

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'این شماره در سیستم وجود ندارد یا تأیید نشده است.'
            ]);
        }

        session([
            'reset_verified' => true,
            'reset_mobile' => $request->phone
        ]);

        Log::info('تأیید موبایل برای بازیابی رمز', ['user_id' => $user->id]);

        return response()->json([
            'success' => true,
            'redirect' => route('password.reset')
        ]);
    }

    // ذخیره رمز جدید
    public function resetPassword(Request $request)
    {
        if (!session('reset_verified')) {
            return redirect()->route('password.request.mobile')
                ->with('error', 'لطفاً ابتدا شماره موبایل خود را تأیید کنید.');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('mobile', session('reset_mobile'))->first();

        if (!$user) {
            return back()->with('error', 'کاربر یافت نشد.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['reset_mobile', 'reset_verified']);

        Log::info('رمز عبور با موفقیت تغییر کرد', ['user_id' => $user->id]);

        return redirect()->route('login')
            ->with('success', 'رمز عبور با موفقیت تغییر کرد. وارد شوید.');
    }

    // ========== تغییر شماره  ==========

    // تغییر شماره موبایل کاربر لاگین شده
    public function changePhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|size:11|unique:users,mobile',
        ]);

        $user = Auth::user();
        $user->mobile = $request->phone;
        $user->phone_verified_at = now();
        $user->save();

        $dashboardRoute = $user->role === 'charity' ? 'charity.dashboard' : 'donor.dashboard';

        Log::info('شماره موبایل کاربر تغییر کرد', [
            'user_id' => $user->id,
            'new_mobile' => $request->phone
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route($dashboardRoute)
        ]);
    }

    // ========== کد OTP ( تست) ==========

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|size:11',
        ]);

        $code = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        PhoneVerification::updateOrCreate(
            ['phone' => $request->phone],
            ['code' => $code, 'expires_at' => $expiresAt]
        );

        session(['verify_phone' => $request->phone]);

        if (config('app.env') === 'local') {
            return response()->json([
                'success' => true,
                'code' => $code,
                'message' => 'کد تأیید با موفقیت ارسال شد'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'کد تأیید به شماره شما ارسال شد'
        ]);
    }

    public function resendCode(Request $request)
    {
        $phone = session('verify_phone');

        if (!$phone) {
            return response()->json([
                'success' => false,
                'error' => 'لطفاً ابتدا شماره خود را وارد کنید'
            ]);
        }

        $code = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        PhoneVerification::updateOrCreate(
            ['phone' => $phone],
            ['code' => $code, 'expires_at' => $expiresAt]
        );

        if (config('app.env') === 'local') {
            return response()->json([
                'success' => true,
                'code' => $code,
                'message' => 'کد جدید ارسال شد'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'کد جدید به شماره شما ارسال شد'
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $phone = session('verify_phone');

        if (!$phone) {
            return response()->json([
                'success' => false,
                'error' => 'لطفاً شماره را وارد کنید.'
            ]);
        }

        $verification = PhoneVerification::where('phone', $phone)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return response()->json([
                'success' => false,
                'error' => 'کد نامعتبر یا منقضی شده است.'
            ]);
        }

        $verification->delete();
        session()->forget('verify_phone');

        // ثبت‌نام جدید
        if (session('pending_user_id')) {
            $user = User::find(session('pending_user_id'));

            if ($user) {
                $user->mobile = $phone;
                $user->phone_verified_at = now();
                $user->save();

                Auth::login($user);
                session()->forget('pending_user_id');

                $dashboardRoute = $user->role === 'charity' ? 'charity.dashboard' : 'donor.dashboard';

                return response()->json([
                    'success' => true,
                    'redirect' => route($dashboardRoute)
                ]);
            }
        }

        // بازیابی رمز
        session([
            'reset_verified' => true,
            'reset_mobile' => $phone
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('password.reset')
        ]);
    }
}