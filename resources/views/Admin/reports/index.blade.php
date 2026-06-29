@extends('admin.layouts.admin')

@section('title', 'گزارشات و آمار')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-blue-500">
        <p class="text-gray-500 text-sm">کل خیرها</p>
        <h3 class="text-3xl font-bold">{{ $stats['total_donors'] }}</h3>
        <p class="text-xs text-gray-400 mt-1">فعال: {{ $stats['active_donors'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-green-500">
        <p class="text-gray-500 text-sm">خیریه‌های تأیید شده</p>
        <h3 class="text-3xl font-bold">{{ $stats['approved_charities'] }}</h3>
        <p class="text-xs text-gray-400 mt-1">در انتظار: {{ $stats['pending_charities'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-purple-500">
        <p class="text-gray-500 text-sm">کل کمک‌ها</p>
        <h3 class="text-3xl font-bold">{{ $stats['total_donations'] }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-yellow-500">
        <p class="text-gray-500 text-sm">تحویل داده شده</p>
        <h3 class="text-3xl font-bold">{{ $stats['completed_donations'] }}</h3>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">وضعیت کمک‌ها</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($stats['donations_by_status'] as $item)
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold">{{ $item->count }}</p>
            <p class="text-sm text-gray-500">{{ $item->status }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection