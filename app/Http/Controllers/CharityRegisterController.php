<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Charity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CharityRegisterController extends Controller
{
    // نمایش فرم ثبت‌نام خیریه
    public function showForm()
    {
        return view('auth.register-charity');
    }

    // پردازش ثبت‌نام خیریه
    public function register(Request $request)
    {
           
        // اعتبارسنجی
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:20', // شماره ثابت خیریه
            'registration_number' => 'required|string|max:50|unique:charities',
            'national_id' => 'nullable|string|size:11|unique:charities',
            'manager_name' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:50',
            'license_image' => 'nullable|image|max:2048',
            'national_card_image' => 'nullable|image|max:2048',
            'bank_account_number' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:50',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
        ], [
            // پیام‌های فارسی برای خطاها
            'name.required' => 'نام خیریه الزامی است.',
            'name.max' => 'نام خیریه نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد.',
            'phone.required' => 'شماره تماس الزامی است.',
            'registration_number.required' => 'شماره ثبت الزامی است.',
            'registration_number.unique' => 'این شماره ثبت قبلاً ثبت شده است.',
            'national_id.size' => 'شناسه ملی باید ۱۱ رقم باشد.',
            'national_id.unique' => 'این شناسه ملی قبلاً ثبت شده است.',
            'license_image.image' => 'فایل باید تصویر باشد.',
            'license_image.max' => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',
            'national_card_image.image' => 'فایل باید تصویر باشد.',
            'national_card_image.max' => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',
            'city.required' => 'شهر الزامی است.',
            'address.required' => 'آدرس الزامی است.',
        ]);

        // آپلود تصاویر
        $licensePath = null;
        $cardPath = null;

        try {
            if ($request->hasFile('license_image')) {
                $licensePath = $request->file('license_image')->store('charity_docs', 'public');
            }

            if ($request->hasFile('national_card_image')) {
                $cardPath = $request->file('national_card_image')->store('charity_docs', 'public');
            }
        } catch (\Exception $e) {
            Log::error('خطا در آپلود تصاویر خیریه: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'خطا در آپلود تصاویر. لطفاً دوباره تلاش کنید.');
        }

        try {
            // ایجاد کاربر جدید
            $user = User::create([
                'name' => $request->name,
                'email' => null, // خیریه با ایمیل ثبت‌نام نمی‌کند
                'phone' => $request->phone, // شماره ثابت خیریه
                'mobile' => null, // شماره موبایل بعداً در تأیید پیامکی ثبت می‌شود
                'password' => Hash::make($request->password),
                'role' => 'charity',
                'city' => $request->city,
                'address' => $request->address,
            ]);

            // ایجاد رکورد خیریه
            Charity::create([
                'user_id' => $user->id,
                'registration_number' => $request->registration_number,
                'national_id' => $request->national_id,
                'manager_name' => $request->manager_name,
                'license_number' => $request->license_number,
                'license_image' => $licensePath,
                'national_card_image' => $cardPath,
                'bank_account_number' => $request->bank_account_number,
                'iban' => $request->iban,
                'is_approved' => false, // نیاز به تأیید مدیریت
            ]);

            // لاگ موفقیت
            Log::info('ثبت‌نام خیریه جدید', [
                'user_id' => $user->id,
                'charity_name' => $request->name,
                'registration_number' => $request->registration_number,
                'city' => $request->city
            ]);

            // هدایت به صفحه تأیید شماره موبایل
           Auth::login($user);
           return redirect()->route('verify.phone.form');
            
           

        }
        
        catch (\Exception $e) {
            // در صورت خطا در ثبت‌نام
            Log::error('خطا در ثبت‌نام خیریه: ' . $e->getMessage(), [
                'data' => $request->except(['password', 'password_confirmation'])
            ]);

            // حذف تصاویر آپلود شده در صورت خطا
            if ($licensePath) {
                \Storage::disk('public')->delete($licensePath);
            }
            if ($cardPath) {
                \Storage::disk('public')->delete($cardPath);
            }

            return back()
                ->withInput()
                ->with('error', 'خطا در ثبت‌نام. لطفاً دوباره تلاش کنید.');
        }
    }
}