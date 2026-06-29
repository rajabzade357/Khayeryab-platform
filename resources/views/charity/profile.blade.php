@extends('layouts.app')

@section('body_class', 'bg-gradient-to-r from-green-800 to-blue-950')
@section('body_style', 'animation: gradient 10s ease infinite; background-size: 200% 200%;')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg mb-6">
            ⚠️ {{ session('warning') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ========== بخش نمایش اطلاعات فعلی ========== -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-8">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">اطلاعات فعلی خیریه</h2>
            
            <div class="flex flex-col md:flex-row gap-6">
                <!-- لوگو -->
                <div class="flex-shrink-0 text-center">
                    @if($charity->logo)
                        <img src="{{ asset('storage/' . $charity->logo) }}" 
                             class="w-32 h-32 rounded-full object-cover mx-auto border-2 border-gray-300">
                    @else
                        <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center mx-auto">
                            <span class="text-4xl text-gray-400"></span>
                        </div>
                    @endif
                    <p class="text-xs text-gray-400 mt-2">
                        @if($charity->is_approved)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full">تأیید شده</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">در انتظار تأیید</span>
                        @endif
                    </p>
                </div>

                <!-- اطلاعات -->
                <div class="flex-1 space-y-3">
                    <div><span class="font-bold text-gray-600">نام خیریه:</span> <span class="text-gray-800 mr-2">{{ $user->name }}</span></div>
                    <div><span class="font-bold text-gray-600">مدیرعامل:</span> <span class="text-gray-800 mr-2">{{ $charity->manager_name ?? 'ثبت نشده' }}</span></div>
                    <div><span class="font-bold text-gray-600">شماره ثبت:</span> <span class="text-gray-800 mr-2">{{ $charity->registration_number ?? 'ثبت نشده' }}</span></div>
                    <div><span class="font-bold text-gray-600">شناسه ملی:</span> <span class="text-gray-800 mr-2">{{ $charity->national_id ?? 'ثبت نشده' }}</span></div>
                    <div><span class="font-bold text-gray-600">شماره پروانه:</span> <span class="text-gray-800 mr-2">{{ $charity->license_number ?? 'ثبت نشده' }}</span></div>
                    
                    {{-- مدارک --}}
                    <div>
                        <span class="font-bold text-gray-600">تصویر پروانه:</span>
                        @if($charity->license_image)
                            <span class="text-green-600 text-xs">بارگذاری شده</span>
                        @else
                            <span class="text-gray-400 text-xs">ثبت نشده</span>
                        @endif
                    </div>
                    <div>
                        <span class="font-bold text-gray-600">تصویر کارت ملی:</span>
                        @if($charity->national_card_image)
                            <span class="text-green-600 text-xs">بارگذاری شده</span>
                        @else
                            <span class="text-gray-400 text-xs">ثبت نشده</span>
                        @endif
                    </div>

                    <div><span class="font-bold text-gray-600">شماره حساب:</span> <span class="text-gray-800 mr-2">{{ $charity->bank_account_number ?? 'ثبت نشده' }}</span></div>
                    <div><span class="font-bold text-gray-600">شبا:</span> <span class="text-gray-800 mr-2">{{ $charity->iban ?? 'ثبت نشده' }}</span></div>
                    <div><span class="font-bold text-gray-600">شهر:</span> <span class="text-gray-800 mr-2">{{ $user->city ?? 'ثبت نشده' }}</span></div>
                    <div><span class="font-bold text-gray-600">تلفن:</span> <span class="text-gray-800 mr-2">{{ $user->phone ?? 'ثبت نشده' }}</span></div>
                    <div><span class="font-bold text-gray-600">آدرس:</span> <span class="text-gray-800 mr-2">{{ $user->address ?? 'ثبت نشده' }}</span></div>
                    <div><span class="font-bold text-gray-600">توضیحات:</span> <span class="text-gray-800 mr-2">{{ $charity->description ?? 'ثبت نشده' }}</span></div>
                    
                    {{-- شماره موبایل --}}
                    <div class="border-t pt-3">
                        <div class="flex  gap-3 flex-wrap">
                            <span class="font-bold text-gray-600">شماره همراه:</span>
                            <span class="text-gray-800">{{ $user->mobile ?? 'ثبت نشده' }}</span>
                            @if($user->mobile)
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">تأیید شده</span>
                            @endif
                            <a href="{{ route('phone.change') }}" class="text-blue-600 text-sm hover:underline">
                                <i class="fas fa-edit ml-1"></i>تغییر شماره
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ========== بخش ویرایش اطلاعات ========== -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">ویرایش اطلاعات</h2>
            {{-- هشدار --}}
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-700 text-sm">
                 ⚠️  در صورت تغییر، وضعیت تأیید خیریه را به حالت تعلیق درمیاید و نیاز به بررسی مجدد توسط مدیریت دارد.
                </p>
            </div>
            <br>
            <form method="POST" action="{{ route('charity.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- نام خیریه --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">نام خیریه *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    {{-- مدیرعامل  --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">
                            نام مدیرعامل *
                            <span class="text-red-500 text-xs"></span>
                        </label>
                        <input type="text" name="manager_name" 
                               value="{{ old('manager_name', $charity->manager_name) }}" 
                               class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    {{-- شماره ثبت  --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">
                            شماره ثبت *
                            <span class="text-red-500 text-xs"></span>
                        </label>
                        <input type="text" name="registration_number" 
                               value="{{ old('registration_number', $charity->registration_number) }}" 
                               class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    {{-- شناسه ملی  --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">
                            شناسه ملی *
                            <span class="text-red-500 text-xs"></span>
                        </label>
                        <input type="text" name="national_id" 
                        value="{{ old('national_id', $charity->national_id) }}" 
                        class="w-full border border-gray-300 rounded-lg p-3" maxlength="11">
                    </div>

                    {{-- شماره پروانه  --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">
                            شماره پروانه *
                            <span class="text-red-500 text-xs"></span>
                        </label>
                        <input type="text" name="license_number" 
                               value="{{ old('license_number', $charity->license_number) }}" 
                               class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    {{-- تلفن --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">تلفن *</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                               class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    {{-- شهر --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">شهر *</label>
                        <select name="city" class="w-full border border-gray-300 rounded-lg p-3">
                            <option value="آبادان" {{ ($user->city ?? '') == 'آبادان' ? 'selected' : '' }}>آبادان</option>
                            <option value="آباده" {{ ($user->city ?? '') == 'آباده' ? 'selected' : '' }}>آباده</option>
                            <option value="آبیک" {{ ($user->city ?? '') == 'آبیک' ? 'selected' : '' }}>آبیک</option>
                            <option value="آبدانان" {{ ($user->city ?? '') == 'آبدانان' ? 'selected' : '' }}>آبدانان</option>
                            <option value="آذرشهر" {{ ($user->city ?? '') == 'آذرشهر' ? 'selected' : '' }}>آذرشهر</option>
                            <option value="آستارا" {{ ($user->city ?? '') == 'آستارا' ? 'selected' : '' }}>آستارا</option>
                            <option value="آشتیان" {{ ($user->city ?? '') == 'آشتیان' ? 'selected' : '' }}>آشتیان</option>
                            <option value="آق‌قلا" {{ ($user->city ?? '') == 'آق‌قلا' ? 'selected' : '' }}>آق‌قلا</option>
                            <option value="آمل" {{ ($user->city ?? '') == 'آمل' ? 'selected' : '' }}>آمل</option>
                            <option value="ابهر" {{ ($user->city ?? '') == 'ابهر' ? 'selected' : '' }}>ابهر</option>
                            <option value="اردبیل" {{ ($user->city ?? '') == 'اردبیل' ? 'selected' : '' }}>اردبیل</option>
                            <option value="اردکان" {{ ($user->city ?? '') == 'اردکان' ? 'selected' : '' }}>اردکان</option>
                            <option value="اراک" {{ ($user->city ?? '') == 'اراک' ? 'selected' : '' }}>اراک</option>
                            <option value="ارومیه" {{ ($user->city ?? '') == 'ارومیه' ? 'selected' : '' }}>ارومیه</option>
                            <option value="اسلام‌آباد غرب" {{ ($user->city ?? '') == 'اسلام‌آباد غرب' ? 'selected' : '' }}>اسلام‌آباد غرب</option>
                            <option value="اسلامشهر" {{ ($user->city ?? '') == 'اسلامشهر' ? 'selected' : '' }}>اسلامشهر</option>
                            <option value="اشتهارد" {{ ($user->city ?? '') == 'اشتهارد' ? 'selected' : '' }}>اشتهارد</option>
                            <option value="اصفهان" {{ ($user->city ?? '') == 'اصفهان' ? 'selected' : '' }}>اصفهان</option>
                            <option value="الوند" {{ ($user->city ?? '') == 'الوند' ? 'selected' : '' }}>الوند</option>
                            <option value="اهواز" {{ ($user->city ?? '') == 'اهواز' ? 'selected' : '' }}>اهواز</option>
                            <option value="ایلام" {{ ($user->city ?? '') == 'ایلام' ? 'selected' : '' }}>ایلام</option>
                            <option value="ایرانشهر" {{ ($user->city ?? '') == 'ایرانشهر' ? 'selected' : '' }}>ایرانشهر</option>
                            <option value="بابل" {{ ($user->city ?? '') == 'بابل' ? 'selected' : '' }}>بابل</option>
                            <option value="بافق" {{ ($user->city ?? '') == 'بافق' ? 'selected' : '' }}>بافق</option>
                            <option value="بانه" {{ ($user->city ?? '') == 'بانه' ? 'selected' : '' }}>بانه</option>
                            <option value="بندر ترکمن" {{ ($user->city ?? '') == 'بندر ترکمن' ? 'selected' : '' }}>بندر ترکمن</option>
                            <option value="بندر لنگه" {{ ($user->city ?? '') == 'بندر لنگه' ? 'selected' : '' }}>بندر لنگه</option>
                            <option value="بندرعباس" {{ ($user->city ?? '') == 'بندرعباس' ? 'selected' : '' }}>بندرعباس</option>
                            <option value="بیرجند" {{ ($user->city ?? '') == 'بیرجند' ? 'selected' : '' }}>بیرجند</option>
                            <option value="برازجان" {{ ($user->city ?? '') == 'برازجان' ? 'selected' : '' }}>برازجان</option>
                            <option value="بروجن" {{ ($user->city ?? '') == 'بروجن' ? 'selected' : '' }}>بروجن</option>
                            <option value="بروجرد" {{ ($user->city ?? '') == 'بروجرد' ? 'selected' : '' }}>بروجرد</option>
                            <option value="بوئین‌زهرا" {{ ($user->city ?? '') == 'بوئین‌زهرا' ? 'selected' : '' }}>بوئین‌زهرا</option>
                            <option value="بوکان" {{ ($user->city ?? '') == 'بوکان' ? 'selected' : '' }}>بوکان</option>
                            <option value="بم" {{ ($user->city ?? '') == 'بم' ? 'selected' : '' }}>بم</option>
                            <option value="بجنورد" {{ ($user->city ?? '') == 'بجنورد' ? 'selected' : '' }}>بجنورد</option>
                            <option value="بوشهر" {{ ($user->city ?? '') == 'بوشهر' ? 'selected' : '' }}>بوشهر</option>
                            <option value="پارس‌آباد" {{ ($user->city ?? '') == 'پارس‌آباد' ? 'selected' : '' }}>پارس‌آباد</option>
                            <option value="پاوه" {{ ($user->city ?? '') == 'پاوه' ? 'selected' : '' }}>پاوه</option>
                            <option value="تفت" {{ ($user->city ?? '') == 'تفت' ? 'selected' : '' }}>تفت</option>
                            <option value="تهران" {{ ($user->city ?? '') == 'تهران' ? 'selected' : '' }}>تهران</option>
                            <option value="تربت حیدریه" {{ ($user->city ?? '') == 'تربت حیدریه' ? 'selected' : '' }}>تربت حیدریه</option>
                            <option value="تویسرکان" {{ ($user->city ?? '') == 'تویسرکان' ? 'selected' : '' }}>تویسرکان</option>
                            <option value="تبریز" {{ ($user->city ?? '') == 'تبریز' ? 'selected' : '' }}>تبریز</option>
                            <option value="جاسک" {{ ($user->city ?? '') == 'جاسک' ? 'selected' : '' }}>جاسک</option>
                            <option value="جاجرم" {{ ($user->city ?? '') == 'جاجرم' ? 'selected' : '' }}>جاجرم</option>
                            <option value="جعفریه" {{ ($user->city ?? '') == 'جعفریه' ? 'selected' : '' }}>جعفریه</option>
                            <option value="جهرم" {{ ($user->city ?? '') == 'جهرم' ? 'selected' : '' }}>جهرم</option>
                            <option value="جوانرود" {{ ($user->city ?? '') == 'جوانرود' ? 'selected' : '' }}>جوانرود</option>
                            <option value="جیرفت" {{ ($user->city ?? '') == 'جیرفت' ? 'selected' : '' }}>جیرفت</option>
                            <option value="چابهار" {{ ($user->city ?? '') == 'چابهار' ? 'selected' : '' }}>چابهار</option>
                            <option value="خرم‌آباد" {{ ($user->city ?? '') == 'خرم‌آباد' ? 'selected' : '' }}>خرم‌آباد</option>
                            <option value="خرمشهر" {{ ($user->city ?? '') == 'خرمشهر' ? 'selected' : '' }}>خرمشهر</option>
                            <option value="خرمدره" {{ ($user->city ?? '') == 'خرمدره' ? 'selected' : '' }}>خرمدره</option>
                            <option value="خمین" {{ ($user->city ?? '') == 'خمین' ? 'selected' : '' }}>خمین</option>
                            <option value="خمینی‌شهر" {{ ($user->city ?? '') == 'خمینی‌شهر' ? 'selected' : '' }}>خمینی‌شهر</option>
                            <option value="خوی" {{ ($user->city ?? '') == 'خوی' ? 'selected' : '' }}>خوی</option>
                            <option value="دامغان" {{ ($user->city ?? '') == 'دامغان' ? 'selected' : '' }}>دامغان</option>
                            <option value="دهدشت" {{ ($user->city ?? '') == 'دهدشت' ? 'selected' : '' }}>دهدشت</option>
                            <option value="دهلران" {{ ($user->city ?? '') == 'دهلران' ? 'selected' : '' }}>دهلران</option>
                            <option value="دزفول" {{ ($user->city ?? '') == 'دزفول' ? 'selected' : '' }}>دزفول</option>
                            <option value="دلیجان" {{ ($user->city ?? '') == 'دلیجان' ? 'selected' : '' }}>دلیجان</option>
                            <option value="دیر" {{ ($user->city ?? '') == 'دیر' ? 'selected' : '' }}>دیر</option>
                            <option value="دره‌شهر" {{ ($user->city ?? '') == 'دره‌شهر' ? 'selected' : '' }}>دره‌شهر</option>
                            <option value="دورود" {{ ($user->city ?? '') == 'دورود' ? 'selected' : '' }}>دورود</option>
                            <option value="رشت" {{ ($user->city ?? '') == 'رشت' ? 'selected' : '' }}>رشت</option>
                            <option value="رفسنجان" {{ ($user->city ?? '') == 'رفسنجان' ? 'selected' : '' }}>رفسنجان</option>
                            <option value="رودسر" {{ ($user->city ?? '') == 'رودسر' ? 'selected' : '' }}>رودسر</option>
                            <option value="ری" {{ ($user->city ?? '') == 'ری' ? 'selected' : '' }}>ری</option>
                            <option value="زابل" {{ ($user->city ?? '') == 'زابل' ? 'selected' : '' }}>زابل</option>
                            <option value="زاهدان" {{ ($user->city ?? '') == 'زاهدان' ? 'selected' : '' }}>زاهدان</option>
                            <option value="زنجان" {{ ($user->city ?? '') == 'زنجان' ? 'selected' : '' }}>زنجان</option>
                            <option value="ساری" {{ ($user->city ?? '') == 'ساری' ? 'selected' : '' }}>ساری</option>
                            <option value="ساوجبلاغ" {{ ($user->city ?? '') == 'ساوجبلاغ' ? 'selected' : '' }}>ساوجبلاغ</option>
                            <option value="ساوه" {{ ($user->city ?? '') == 'ساوه' ? 'selected' : '' }}>ساوه</option>
                            <option value="سبزوار" {{ ($user->city ?? '') == 'سبزوار' ? 'selected' : '' }}>سبزوار</option>
                            <option value="سراوان" {{ ($user->city ?? '') == 'سراوان' ? 'selected' : '' }}>سراوان</option>
                            <option value="سلفچگان" {{ ($user->city ?? '') == 'سلفچگان' ? 'selected' : '' }}>سلفچگان</option>
                            <option value="سنندج" {{ ($user->city ?? '') == 'سنندج' ? 'selected' : '' }}>سنندج</option>
                            <option value="سمنان" {{ ($user->city ?? '') == 'سمنان' ? 'selected' : '' }}>سمنان</option>
                            <option value="سیرجان" {{ ($user->city ?? '') == 'سیرجان' ? 'selected' : '' }}>سیرجان</option>
                            <option value="سی‌سخت" {{ ($user->city ?? '') == 'سی‌سخت' ? 'selected' : '' }}>سی‌سخت</option>
                            <option value="شاهین‌شهر" {{ ($user->city ?? '') == 'شاهین‌شهر' ? 'selected' : '' }}>شاهین‌شهر</option>
                            <option value="شاهرود" {{ ($user->city ?? '') == 'شاهرود' ? 'selected' : '' }}>شاهرود</option>
                            <option value="شهریار" {{ ($user->city ?? '') == 'شهریار' ? 'selected' : '' }}>شهریار</option>
                            <option value="شیراز" {{ ($user->city ?? '') == 'شیراز' ? 'selected' : '' }}>شیراز</option>
                            <option value="شیروان" {{ ($user->city ?? '') == 'شیروان' ? 'selected' : '' }}>شیروان</option>
                            <option value="شهرکرد" {{ ($user->city ?? '') == 'شهرکرد' ? 'selected' : '' }}>شهرکرد</option>
                            <option value="طبس" {{ ($user->city ?? '') == 'طبس' ? 'selected' : '' }}>طبس</option>
                            <option value="فارسان" {{ ($user->city ?? '') == 'فارسان' ? 'selected' : '' }}>فارسان</option>
                            <option value="فاروج" {{ ($user->city ?? '') == 'فاروج' ? 'selected' : '' }}>فاروج</option>
                            <option value="فردوس" {{ ($user->city ?? '') == 'فردوس' ? 'selected' : '' }}>فردوس</option>
                            <option value="فردیس" {{ ($user->city ?? '') == 'فردیس' ? 'selected' : '' }}>فردیس</option>
                            <option value="قائم‌شهر" {{ ($user->city ?? '') == 'قائم‌شهر' ? 'selected' : '' }}>قائم‌شهر</option>
                            <option value="قائن" {{ ($user->city ?? '') == 'قائن' ? 'selected' : '' }}>قائن</option>
                            <option value="قروه" {{ ($user->city ?? '') == 'قروه' ? 'selected' : '' }}>قروه</option>
                            <option value="قزوین" {{ ($user->city ?? '') == 'قزوین' ? 'selected' : '' }}>قزوین</option>
                            <option value="قشم" {{ ($user->city ?? '') == 'قشم' ? 'selected' : '' }}>قشم</option>
                            <option value="قم" {{ ($user->city ?? '') == 'قم' ? 'selected' : '' }}>قم</option>
                            <option value="قوچان" {{ ($user->city ?? '') == 'قوچان' ? 'selected' : '' }}>قوچان</option>
                            <option value="قیدار" {{ ($user->city ?? '') == 'قیدار' ? 'selected' : '' }}>قیدار</option>
                            <option value="کازرون" {{ ($user->city ?? '') == 'کازرون' ? 'selected' : '' }}>کازرون</option>
                            <option value="کاشان" {{ ($user->city ?? '') == 'کاشان' ? 'selected' : '' }}>کاشان</option>
                            <option value="کرج" {{ ($user->city ?? '') == 'کرج' ? 'selected' : '' }}>کرج</option>
                            <option value="کرمان" {{ ($user->city ?? '') == 'کرمان' ? 'selected' : '' }}>کرمان</option>
                            <option value="کرمانشاه" {{ ($user->city ?? '') == 'کرمانشاه' ? 'selected' : '' }}>کرمانشاه</option>
                            <option value="کنگان" {{ ($user->city ?? '') == 'کنگان' ? 'selected' : '' }}>کنگان</option>
                            <option value="کنگاور" {{ ($user->city ?? '') == 'کنگاور' ? 'selected' : '' }}>کنگاور</option>
                            <option value="کبودرآهنگ" {{ ($user->city ?? '') == 'کبودرآهنگ' ? 'selected' : '' }}>کبودرآهنگ</option>
                            <option value="کهک" {{ ($user->city ?? '') == 'کهک' ? 'selected' : '' }}>کهک</option>
                            <option value="کوهدشت" {{ ($user->city ?? '') == 'کوهدشت' ? 'selected' : '' }}>کوهدشت</option>
                            <option value="کوهرنگ" {{ ($user->city ?? '') == 'کوهرنگ' ? 'selected' : '' }}>کوهرنگ</option>
                            <option value="گرگان" {{ ($user->city ?? '') == 'گرگان' ? 'selected' : '' }}>گرگان</option>
                            <option value="گرمسار" {{ ($user->city ?? '') == 'گرمسار' ? 'selected' : '' }}>گرمسار</option>
                            <option value="گرمی" {{ ($user->city ?? '') == 'گرمی' ? 'selected' : '' }}>گرمی</option>
                            <option value="گناوه" {{ ($user->city ?? '') == 'گناوه' ? 'selected' : '' }}>گناوه</option>
                            <option value="گنبد کاووس" {{ ($user->city ?? '') == 'گنبد کاووس' ? 'selected' : '' }}>گنبد کاووس</option>
                            <option value="گچساران" {{ ($user->city ?? '') == 'گچساران' ? 'selected' : '' }}>گچساران</option>
                            <option value="لار" {{ ($user->city ?? '') == 'لار' ? 'selected' : '' }}>لار</option>
                            <option value="لاهیجان" {{ ($user->city ?? '') == 'لاهیجان' ? 'selected' : '' }}>لاهیجان</option>
                            <option value="لردگان" {{ ($user->city ?? '') == 'لردگان' ? 'selected' : '' }}>لردگان</option>
                            <option value="لنگرود" {{ ($user->city ?? '') == 'لنگرود' ? 'selected' : '' }}>لنگرود</option>
                            <option value="لیکک" {{ ($user->city ?? '') == 'لیکک' ? 'selected' : '' }}>لیکک</option>
                            <option value="ماهشهر" {{ ($user->city ?? '') == 'ماهشهر' ? 'selected' : '' }}>ماهشهر</option>
                            <option value="ماهنشان" {{ ($user->city ?? '') == 'ماهنشان' ? 'selected' : '' }}>ماهنشان</option>
                            <option value="مراغه" {{ ($user->city ?? '') == 'مراغه' ? 'selected' : '' }}>مراغه</option>
                            <option value="مرند" {{ ($user->city ?? '') == 'مرند' ? 'selected' : '' }}>مرند</option>
                            <option value="مرودشت" {{ ($user->city ?? '') == 'مرودشت' ? 'selected' : '' }}>مرودشت</option>
                            <option value="مریوان" {{ ($user->city ?? '') == 'مریوان' ? 'selected' : '' }}>مریوان</option>
                            <option value="مشگین‌شهر" {{ ($user->city ?? '') == 'مشگین‌شهر' ? 'selected' : '' }}>مشگین‌شهر</option>
                            <option value="مشهد" {{ ($user->city ?? '') == 'مشهد' ? 'selected' : '' }}>مشهد</option>
                            <option value="ملایر" {{ ($user->city ?? '') == 'ملایر' ? 'selected' : '' }}>ملایر</option>
                            <option value="مهاباد" {{ ($user->city ?? '') == 'مهاباد' ? 'selected' : '' }}>مهاباد</option>
                            <option value="مهران" {{ ($user->city ?? '') == 'مهران' ? 'selected' : '' }}>مهران</option>
                            <option value="مهدی‌شهر" {{ ($user->city ?? '') == 'مهدی‌شهر' ? 'selected' : '' }}>مهدی‌شهر</option>
                            <option value="میاندوآب" {{ ($user->city ?? '') == 'میاندوآب' ? 'selected' : '' }}>میاندوآب</option>
                            <option value="میانه" {{ ($user->city ?? '') == 'میانه' ? 'selected' : '' }}>میانه</option>
                            <option value="میبد" {{ ($user->city ?? '') == 'میبد' ? 'selected' : '' }}>میبد</option>
                            <option value="میناب" {{ ($user->city ?? '') == 'میناب' ? 'selected' : '' }}>میناب</option>
                            <option value="نجف‌آباد" {{ ($user->city ?? '') == 'نجف‌آباد' ? 'selected' : '' }}>نجف‌آباد</option>
                            <option value="نظرآباد" {{ ($user->city ?? '') == 'نظرآباد' ? 'selected' : '' }}>نظرآباد</option>
                            <option value="نهاوند" {{ ($user->city ?? '') == 'نهاوند' ? 'selected' : '' }}>نهاوند</option>
                            <option value="نهبندان" {{ ($user->city ?? '') == 'نهبندان' ? 'selected' : '' }}>نهبندان</option>
                            <option value="نیشابور" {{ ($user->city ?? '') == 'نیشابور' ? 'selected' : '' }}>نیشابور</option>
                            <option value="نوشهر" {{ ($user->city ?? '') == 'نوشهر' ? 'selected' : '' }}>نوشهر</option>
                            <option value="ورامین" {{ ($user->city ?? '') == 'ورامین' ? 'selected' : '' }}>ورامین</option>
                            <option value="یاسوج" {{ ($user->city ?? '') == 'یاسوج' ? 'selected' : '' }}>یاسوج</option>
                            <option value="یزد" {{ ($user->city ?? '') == 'یزد' ? 'selected' : '' }}>یزد</option>
                        </select>
                    </div>

                    {{-- شماره حساب --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">شماره حساب</label>
                        <input type="text" name="bank_account_number" 
                               value="{{ old('bank_account_number', $charity->bank_account_number) }}" 
                               class="w-full border border-gray-300 rounded-lg p-3">
                    </div>

                    {{-- شبا --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">کد شبا</label>
                        <input type="text" name="iban" value="{{ old('iban', $charity->iban) }}" 
                               class="w-full border border-gray-300 rounded-lg p-3" 
                               placeholder="IR...">
                    </div>

                    {{-- آدرس --}}
                    <div class="md:col-span-2">
                        <label class="block font-bold text-gray-700 mb-2">آدرس *</label>
                        <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg p-3">{{ old('address', $user->address ?? '') }}</textarea>
                    </div>

                    {{-- تصویر پروانه  --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">
                            تصویر پروانه فعالیت
                            <span class="text-red-500 text-xs"></span>
                        </label>
                        @if($charity->license_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $charity->license_image) }}" 
                                     class="w-32 h-32 object-cover rounded border">
                            </div>
                        @endif
                        <input type="file" name="license_image" accept="image/*" 
                               class="w-full border border-gray-300 rounded-lg p-2">
                    </div>

                    {{-- تصویر کارت ملی  --}}
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">
                            تصویر کارت ملی مدیرعامل
                            <span class="text-red-500 text-xs"></span>
                        </label>
                        @if($charity->national_card_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $charity->national_card_image) }}" 
                                     class="w-32 h-32 object-cover rounded border">
                            </div>
                        @endif
                        <input type="file" name="national_card_image" accept="image/*" 
                               class="w-full border border-gray-300 rounded-lg p-2">
                    </div>

                    {{-- توضیحات --}}
                    <div class="md:col-span-2">
                        <label class="block font-bold text-gray-700 mb-2">توضیحات</label>
                        <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg p-3">{{ old('description', $charity->description ?? '') }}</textarea>
                    </div>

                    {{-- لوگو --}}
                    <div class="md:col-span-2">
                        <label class="block font-bold text-gray-700 mb-2">لوگوی خیریه</label>
                        @if($charity->logo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $charity->logo) }}" 
                                     class="w-24 h-24 rounded-full object-cover border-2 border-gray-300">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" 
                               class="w-full border border-gray-300 rounded-lg p-2">
                        <p class="text-xs text-gray-400 mt-1">فرمت: JPG, PNG | حداکثر ۲ مگابایت</p>
                    </div>
                </div>

                

                <div class="mt-6">
                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition">
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection