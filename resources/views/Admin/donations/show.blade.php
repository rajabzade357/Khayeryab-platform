@extends('admin.layouts.admin')

@section('title', 'جزئیات کمک')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="grid grid-cols-2 gap-4">
        <div><p class="text-gray-500">عنوان</p><p class="font-bold text-lg">{{ $donation->title }}</p></div>
        <div><p class="text-gray-500">خیر</p><p class="font-bold">{{ $donation->donor->name ?? '-' }}</p></div>
        <div><p class="text-gray-500">خیریه</p><p class="font-bold">{{ $donation->charity->user->name ?? '-' }}</p></div>
        <div><p class="text-gray-500">دسته‌بندی</p><p class="font-bold">{{ $donation->category === 'small' ? 'خُرد' : 'کلان' }}</p></div>
        <div><p class="text-gray-500">روش تحویل</p><p class="font-bold">{{ $donation->delivery_method }}</p></div>
        <div><p class="text-gray-500">وضعیت</p><p class="font-bold">{{ $donation->status }}</p></div>
        <div class="col-span-2"><p class="text-gray-500">توضیحات</p><p>{{ $donation->description ?? '-' }}</p></div>
    </div>

    <form method="POST" action="{{ route('admin.donations.status', $donation->id) }}" class="mt-6 border-t pt-6">
        @csrf @method('PUT')
        <label class="block text-sm font-bold mb-2">تغییر وضعیت</label>
        <select name="status" class="border rounded-lg p-2">
            <option value="waiting_for_charity">در انتظار خیریه</option>
            <option value="accepted_by_charity">پذیرفته شده</option>
            <option value="delivered">تحویل داده شده</option>
            <option value="rejected">رد شده</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-2">بروزرسانی</button>
    </form>
</div>
@endsection