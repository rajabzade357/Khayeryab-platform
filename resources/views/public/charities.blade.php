@extends('layouts.app')

@section('title', 'خیریه‌های همکار')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">خیریه‌های همکار</h1>
        <p class="text-xl text-gray-600">لیست خیریه‌های تأیید شده</p>
    </div>

    <!-- بخش جستجو و فیلتر -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('charities.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="جستجوی نام خیریه..." value="{{ request('search') }}"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500">
            </div>
            <div class="w-full md:w-64">
                <select name="city" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500">
                    <option value="">همه شهرها</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                <i class="fas fa-search ml-2"></i> جستجو
            </button>
            @if(request('search') || request('city'))
                <a href="{{ route('charities.index') }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 text-center">
                    حذف فیلتر
                </a>
            @endif
        </form>
    </div>

    <!-- لیست خیریه‌ها -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($charities as $charity)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="p-6">
                    <!-- اطلاعات خیریه -->
                    <div class="flex items-center gap-4 mb-4">
                        @if($charity->logo)
                            <img src="{{ Storage::url($charity->logo) }}" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl text-green-600"></span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $charity->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $charity->user->city }}</p>
                        </div>
                    </div>

                    <!-- اطلاعات  -->
                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user w-5 text-green-600"></i>
                            <span>مالک خیریه : {{ $charity->manager_name ?? 'ثبت نشده' }}</span>
                        </div>
                         <div class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt w-5 text-green-600"></i>
                            <span>آدرس : {{ $charity->user->address ?? 'آدرس ثبت نشده' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-phone w-5 text-green-600"></i>
                            <span>تلفن :{{ $charity->user->phone ?? 'تلفن ثبت نشده' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                        <i class="fas fa-id-card w-5 text-green-600"></i>
                            <span>شماره ثبت: {{ $charity->registration_number ?? 'ثبت نشده' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                        <i class="fas fa-credit-card w-5 text-green-600"></i>
                            <span>شماره حساب خیریه : {{ $charity->bank_account_number ?? 'ثبت نشده' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                        <i class="fas fa-money-bill-transfer w-5 text-green-600"></i>
                            <span>شبا : {{ $charity->iban ?? 'ثبت نشده' }}</span>
                        </div>
                       
                    </div>

                    <!-- وسایل ترجیحی -->
                    @if($charity->preferredItems->count() > 0)
                        <div class="border-t pt-4 mt-2">
                            <p class="text-sm font-bold text-gray-700 mb-2"> وسایل ترجیحی:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($charity->preferredItems as $item)
                                <span class="text-sm bg-green-100 text-green-700 px-4 py-2 rounded-lg inline-block">
                                            {{ $item->title }}
                                        <br>
                                        {{ $item->description }}
                                        <br>
                                        @if($item->priority === 'high')
                                            <span class="text-red-500">اولویت بالا</span>
                                        @elseif($item->priority === 'medium')
                                            <span class="text-orange-500">اولویت متوسط</span>
                                        @else($item->priority === 'normal')
                                            <span class="text-yellwo-500">اولویت عادی</span>

                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="border-t pt-4 mt-2">
                            <p class="text-sm text-gray-400">هیچ وسیله ترجیحی ثبت نشده است</p>
                        </div>
                    @endif

                    
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">هیچ خیریه‌ای یافت نشد</p>
            </div>
        @endforelse
    </div>

    
    <div class="mt-8">
        {{ $charities->withQueryString()->links() }}
    </div>
</div>
@endsection