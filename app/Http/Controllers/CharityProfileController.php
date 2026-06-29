<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CharityProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $charity = $user->charity;
        
        return view('charity.profile', compact('user', 'charity'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $charity = $user->charity;

        $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:50',
            'national_id' => 'nullable|string|size:11',
            'manager_name' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:50',
            'license_image' => 'nullable|image|max:2048',
            'national_card_image' => 'nullable|image|max:2048',
            'bank_account_number' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|max:2048',
        ]);

        $anythingChanged = false;

        // ========== چک کردن تغییرات کاربر ==========
        if ($user->name !== $request->name) $anythingChanged = true;
        if ($user->city !== $request->city) $anythingChanged = true;
        if ($user->address !== $request->address) $anythingChanged = true;
        if ($user->phone !== $request->phone) $anythingChanged = true;

        // ========== چک کردن تغییرات خیریه ==========
        if ($charity->registration_number !== $request->registration_number) $anythingChanged = true;
        if ($charity->national_id !== $request->national_id) $anythingChanged = true;
        if ($charity->manager_name !== $request->manager_name) $anythingChanged = true;
        if ($charity->license_number !== $request->license_number) $anythingChanged = true;
        if ($charity->bank_account_number !== $request->bank_account_number) $anythingChanged = true;
        if ($charity->iban !== $request->iban) $anythingChanged = true;
        if ($charity->description !== $request->description) $anythingChanged = true;

        // ========== آپلود تصاویر ==========
        if ($request->hasFile('license_image')) {
            if ($charity->license_image) {
                Storage::disk('public')->delete($charity->license_image);
            }
            $charity->license_image = $request->file('license_image')->store('charity_docs', 'public');
            $anythingChanged = true;
        }

        if ($request->hasFile('national_card_image')) {
            if ($charity->national_card_image) {
                Storage::disk('public')->delete($charity->national_card_image);
            }
            $charity->national_card_image = $request->file('national_card_image')->store('charity_docs', 'public');
            $anythingChanged = true;
        }

        if ($request->hasFile('logo')) {
            if ($charity->logo) {
                Storage::disk('public')->delete($charity->logo);
            }
            $charity->logo = $request->file('logo')->store('charity_logos', 'public');
            $anythingChanged = true;
        }

        // ========== ذخیره تغییرات ==========
        $user->update([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        $charity->update([
            'registration_number' => $request->registration_number,
            'national_id' => $request->national_id,
            'manager_name' => $request->manager_name,
            'license_number' => $request->license_number,
            'bank_account_number' => $request->bank_account_number,
            'iban' => $request->iban,
            'description' => $request->description,
        ]);

        // ذخیره فایل‌های آپلود شده
        if (isset($charity->license_image)) $charity->save();
        if (isset($charity->national_card_image)) $charity->save();
        if (isset($charity->logo)) $charity->save();

        // ========== لغو تأیید در صورت هرگونه تغییر ==========
        if ($anythingChanged && $charity->is_approved) {
            $charity->is_approved = false;
            $charity->save();

            return redirect()->route('charity.profile')
                ->with('warning', 'اطلاعات خیریه تغییر کرد. وضعیت تأیید به حالت تعلیق درآمد. لطفاً منتظر بررسی مجدد مدیریت باشید.');
        }

        return redirect()->route('charity.profile')
            ->with('success', 'اطلاعات با موفقیت بروزرسانی شد.');
    }
}