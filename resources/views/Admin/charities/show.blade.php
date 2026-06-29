@extends('admin.layouts.admin')

@section('title', 'جزئیات خیریه')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- اطلاعات خیریه -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">اطلاعات خیریه</h3>
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <p class="text-gray-500 text-sm">نام خیریه</p>
                    <p class="font-bold">{{ $charity->user->name ?? '-' }}</p>
                </div>

                @if($charity->logo)
                    <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">لوگوی خیریه</p>
                    <img src="{{ asset('storage/' . $charity->logo) }}" class="w-32 h-32 rounded-full object-cover">
                    </div>
                @endif

                <div>
                    <p class="text-gray-500 text-sm">مدیرعامل</p>
                    <p class="font-bold">{{ $charity->manager_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">شماره ثبت</p>
                    <p class="font-bold">{{ $charity->registration_number ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">شناسه ملی</p>
                    <p class="font-bold">{{ $charity->national_id ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">شماره تماس</p>
                    <p class="font-bold">{{ $charity->user->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">شماره موبایل</p>
                    <p class="font-bold">{{ $charity->user->mobile ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">شهر</p>
                    <p class="font-bold">{{ $charity->user->city ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">وضعیت</p>
                    @if($charity->is_approved)
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">تأیید شده</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">در انتظار تأیید</span>
                    @endif
                </div>
                <div class="col-span-2">
                    <p class="text-gray-500 text-sm">آدرس</p>
                    <p class="font-bold">{{ $charity->user->address ?? '-' }}</p>
                </div>
            </div>

            <div class="flex gap-2 mt-6">
                @if(!$charity->is_approved)
                    <form method="POST" action="{{ route('admin.charities.approve', $charity->id) }}">
                        @csrf
                        @method('PUT')
                        <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                            <i class="fas fa-check ml-1"></i> تأیید خیریه
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.charities.reject', $charity->id) }}">
                        @csrf
                        @method('PUT')
                        <button class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700">
                            <i class="fas fa-undo ml-1"></i> لغو تأیید
                        </button>
                    </form>
                @endif
                <form method="POST" action="{{ route('admin.charities.toggle-active', $charity->id) }}">
                    @csrf
                    @method('PUT')
                    <button class="{{ $charity->user && $charity->user->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-6 py-2 rounded-lg">
                        <i class="fas fa-power-off ml-1"></i> 
                        {{ $charity->user && $charity->user->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- کمک‌های دریافتی -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">کمک‌های دریافتی</h3>
            @if($charity->donations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-2 text-right">عنوان</th>
                                <th class="p-2 text-right">خیر</th>
                                <th class="p-2 text-right">وضعیت</th>
                                <th class="p-2 text-right">تاریخ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($charity->donations as $donation)
                            <tr>
                                <td class="p-2">{{ $donation->title }}</td>
                                <td class="p-2">{{ $donation->donor->name ?? '-' }}</td>
                                <td class="p-2">{{ $donation->status }}</td>
                                <td class="p-2">{{ $donation->created_at->format('Y/m/d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              @else
                <p class="text-gray-500">هنوز کمکی ثبت نشده است.</p>
            @endif
        </div>
    </div>

    <!-- تصاویر مدارک -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">مدارک</h3>
            @if($charity->license_image)
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">تصویر پروانه فعالیت</p>
                    <img src="{{ asset('storage/' . $charity->license_image) }}" class="w-full rounded-lg">
                </div>
            @endif
            @if($charity->national_card_image)
                <div>
                    <p class="text-sm text-gray-500 mb-2">تصویر کارت ملی</p>
                    <img src="{{ asset('storage/' . $charity->national_card_image) }}" class="w-full rounded-lg">
                </div>
            @endif
        </div>
    </div>
</div>
@endsection