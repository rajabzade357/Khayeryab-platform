<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CharityProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DonorProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharityDashboardController;
use App\Http\Controllers\CharityRegisterController;
use App\Http\Controllers\DonorRegisterController;
use App\Http\Controllers\PublicCharityController;
use App\Http\Controllers\DonorDashboardController;
use App\Http\Controllers\PhoneVerificationController; 
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCharityController;
use App\Http\Controllers\Admin\AdminDonorController;
use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminUserController;



// صفحه اصلی
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/charities', [PublicCharityController::class, 'index'])->name('charities.index');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');


// سوالات متداول
Route::get('/faq', function () {
    return view('public.faq');
})->name('faq');



// ورود ادمین
Route::get('/admin-tocxlog', function () { return view('auth.admin-login');})->name('admin.login');
Route::post('/admin-tocxlog', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');


// پنل مدیریت
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // داشبورد
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // مدیریت خیریه‌ها
    Route::get('/charities', [AdminCharityController::class, 'index'])->name('charities.index');
    Route::get('/charities/{id}', [AdminCharityController::class, 'show'])->name('charities.show');
    Route::put('/charities/{id}/approve', [AdminCharityController::class, 'approve'])->name('charities.approve');
    Route::put('/charities/{id}/reject', [AdminCharityController::class, 'reject'])->name('charities.reject');
    Route::put('/charities/{id}/toggle-active', [AdminCharityController::class, 'toggleActive'])->name('charities.toggle-active');

    // مدیریت خیرها
    Route::get('/donors', [AdminDonorController::class, 'index'])->name('donors.index');
    Route::get('/donors/{id}', [AdminDonorController::class, 'show'])->name('donors.show');
    Route::put('/donors/{id}/toggle-active', [AdminDonorController::class, 'toggleActive'])->name('donors.toggle-active');
    Route::post('/donors/{id}/violation', [AdminDonorController::class, 'addViolation'])->name('donors.violation');

    // مدیریت همه کاربران
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::put('/users/{id}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');

    // مدیریت کمک‌ها
    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/{id}', [AdminDonationController::class, 'show'])->name('donations.show');
    Route::put('/donations/{id}/status', [AdminDonationController::class, 'updateStatus'])->name('donations.status');

    // گزارشات
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/chart-data', [AdminReportController::class, 'chartData'])->name('reports.chart');

    // تنظیمات
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/admin', [AdminSettingController::class, 'addAdmin'])->name('settings.add-admin');
    Route::delete('/settings/admin/{id}', [AdminSettingController::class, 'removeAdmin'])->name('settings.remove-admin');
});



//  ثبت‌نام خیریه
Route::get('/register/charity', [CharityRegisterController::class, 'showForm'])->name('register.charity');
Route::post('/register/charity', [CharityRegisterController::class, 'register'])->name('register.charity.post');


//  ثبت‌نام خیر
Route::get('/register/donor', [DonorRegisterController::class, 'showForm'])->name('register.donor');
Route::post('/register/donor', [DonorRegisterController::class, 'register'])->name('register.donor.post');



// مسیرهای احراز هویت (Breeze)
require __DIR__.'/auth.php';


// فراموشی رمز
Route::get('/forgot-password', function () {return view('auth.forgot-password');})->name('password.request.mobile');

Route::post('/forgot-password/verify', [PhoneVerificationController::class, 'verifyForReset'])->name('password.verify');

// صفحه رمز جدید
Route::get('/reset-password', function () {
    if (!session('reset_verified')) {
        return redirect()->route('password.request.mobile');
    }
    return view('auth.reset-password');
})->name('password.reset');

// ذخیره رمز جدید
Route::post('/reset-password', [PhoneVerificationController::class, 'resetPassword'])->name('password.reset.store');



// مسیرهای محافظت شده با لاگین
Route::middleware(['auth'])->group(function () {



//تایید شماره
Route::get('/verify-phone', [PhoneVerificationController::class, 'showForm'])->name('verify.phone.form');
Route::post('/verify-phone', [PhoneVerificationController::class, 'verifyPhone'])->name('verify.phone.send');

// تغییر شماره 
Route::get('/change-phone', function () {return view('auth.change-phone');})->name('phone.change');


// پروفایل خیر
Route::get('/donor/profile', [DonorProfileController::class, 'index'])->name('donor.profile');
Route::put('/donor/profile', [DonorProfileController::class, 'update'])->name('donor.profile.update');

// داشبورد خیر
Route::get('/donor/dashboard', [DonorDashboardController::class, 'dashboard'])->name('donor.dashboard');
Route::post('/donor/donation/store', [DonorDashboardController::class, 'storeDonation'])->name('donor.donation.store');

// داشبورد خیریه
Route::get('/charity/dashboard', function () { return view('charity.dashboard');})->name('charity.dashboard');

// API های داشبورد خیریه
Route::get('/charity/dashboard-data', [CharityDashboardController::class, 'getData'])->name('charity.dashboard.data');
Route::post('/charity/donation/{id}/approve', [CharityDashboardController::class, 'approveDonation'])->name('charity.donation.approve');
Route::post('/charity/donation/{id}/reject', [CharityDashboardController::class, 'rejectDonation'])->name('charity.donation.reject');
Route::post('/charity/preferred-items', [CharityDashboardController::class, 'addPreferredItem'])->name('charity.preferred.add');
Route::delete('/charity/preferred-items/{id}', [CharityDashboardController::class, 'deletePreferredItem'])->name('charity.preferred.delete');
Route::post('/test-json', [CharityDashboardController::class, 'test']);
Route::post('/charity/donation/{id}/delivered', [CharityDashboardController::class, 'markDelivered'])->name('charity.donation.delivered');
Route::post('/charity/donation/{id}/vehicle-delivered', [CharityDashboardController::class, 'markVehicleDelivered'])->name('charity.donation.vehicle-delivered');
Route::post('/charity/donation/{id}/not-delivered', [CharityDashboardController::class, 'markNotDelivered'])->name('charity.donation.not-delivered');
Route::post('/charity/donation/{id}/undo-approval', [CharityDashboardController::class, 'undoApproval'])->name('charity.donation.undo-approval');
Route::post('/charity/donation/{id}/undo-reject', [CharityDashboardController::class, 'undoReject'])->name('charity.donation.undo-reject');

// پروفایل کاربر (Breeze)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// پروفایل خیریه
Route::get('/charity/profile', [CharityProfileController::class, 'index'])->name('charity.profile');
Route::put('/charity/profile', [CharityProfileController::class, 'update'])->name('charity.profile.update');

});