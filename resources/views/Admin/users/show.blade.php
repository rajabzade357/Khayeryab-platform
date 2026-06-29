@extends('admin.layouts.admin')

@section('title', 'جزئیات کاربر')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="grid grid-cols-2 gap-4">
        <div><p class="text-gray-500">نام</p><p class="font-bold text-lg">{{ $user->name }}</p></div>
        <div><p class="text-gray-500">ایمیل</p><p class="font-bold">{{ $user->email ?? '-' }}</p></div>
        <div><p class="text-gray-500">موبایل</p><p class="font-bold">{{ $user->mobile ?? '-' }}</p></div>
        <div><p class="text-gray-500">نقش</p><p class="font-bold">{{ $user->role }}</p></div>
        <div><p class="text-gray-500">شهر</p><p class="font-bold">{{ $user->city ?? '-' }}</p></div>
        <div><p class="text-gray-500">تخلفات</p><p class="font-bold">{{ $user->violation_count }}</p></div>
        <div><p class="text-gray-500">وضعیت</p>
            @if($user->is_active)
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">فعال</span>
            @else
                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">غیرفعال</span>
            @endif
        </div>
        <div><p class="text-gray-500">تاریخ عضویت</p><p class="font-bold">{{ $user->created_at->format('Y/m/d') }}</p></div>
    </div>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="mt-6 border-t pt-6">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-1">نام</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded-lg p-2">
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">ایمیل</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded-lg p-2">
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">شماره تماس</label>
                <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border rounded-lg p-2">
            </div>
        </div>
        <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg">بروزرسانی</button>
    </form>
</div>
@endsection