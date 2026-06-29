@extends('admin.layouts.admin')

@section('title', 'جزئیات خیر')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">اطلاعات خیر</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-gray-500 text-sm">نام</p><p class="font-bold">{{ $donor->name }}</p></div>
                <div><p class="text-gray-500 text-sm">موبایل</p><p class="font-bold">{{ $donor->mobile ?? '-' }}</p></div>
                <div><p class="text-gray-500 text-sm">شهر</p><p class="font-bold">{{ $donor->city ?? '-' }}</p></div>
                <div><p class="text-gray-500 text-sm">تعداد تخلفات</p>
                    <span class="font-bold text-lg {{ $donor->violation_count >= 3 ? 'text-red-600' : '' }}">{{ $donor->violation_count }}</span>
                </div>
                <div><p class="text-gray-500 text-sm">وضعیت</p>
                    @if($donor->is_active)
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">فعال</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">غیرفعال</span>
                    @endif
                </div>
                <div><p class="text-gray-500 text-sm">تاریخ عضویت</p><p class="font-bold">{{ $donor->created_at->format('Y/m/d') }}</p></div>
            </div>

            <div class="flex gap-2 mt-6">
                <form method="POST" action="{{ route('admin.donors.toggle-active', $donor->id) }}">
                    @csrf @method('PUT')
                    <button class="{{ $donor->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-6 py-2 rounded-lg">
                        {{ $donor->is_active ? 'غیرفعال کردن' : 'فعال کردن' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- ثبت تخلف -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">ثبت تخلف جدید</h3>
            <form method="POST" action="{{ route('admin.donors.violation', $donor->id) }}">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">تعداد تخلف (مثبت یا منفی)</label>
                        <input type="number" name="count" class="w-full border rounded-lg p-2" value="1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">دلیل</label>
                        <input type="text" name="reason" class="w-full border rounded-lg p-2" placeholder="دلیل ثبت تخلف...">
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                    ثبت تخلف
                </button>
            </form>
        </div>

        <!-- تاریخچه تخلفات -->
        @if($donor->violations && $donor->violations->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">تاریخچه تخلفات</h3>
            <div class="space-y-2">
                @foreach($donor->violations as $violation)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <span class="font-bold {{ $violation->count > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $violation->count > 0 ? '+' : '' }}{{ $violation->count }}
                        </span>
                        <span class="text-sm text-gray-500 mr-2">{{ $violation->reason ?? 'بدون دلیل' }}</span>
                    </div>
                    <span class="text-xs text-gray-400">{{ $violation->created_at->format('Y/m/d H:i') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- کمک‌های این خیر -->
    <div class="bg-white rounded-xl shadow-sm p-6 h-fit">
        <h3 class="text-lg font-bold text-gray-800 mb-4">کمک‌های انجام شده</h3>
        @if($donor->donations->count() > 0)
            @foreach($donor->donations as $donation)
            <div class="p-3 bg-gray-50 rounded-lg mb-2">
                <p class="font-bold text-sm">{{ $donation->title }}</p>
                <p class="text-xs text-gray-500">{{ $donation->status }}</p>
            </div>
            @endforeach
        @else
            <p class="text-gray-500 text-sm">هنوز کمکی ثبت نشده.</p>
        @endif
    </div>
</div>
@endsection