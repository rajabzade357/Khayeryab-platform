@extends('admin.layouts.admin')

@section('title', 'مدیریت خیریه‌ها')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b flex flex-col md:flex-row justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">لیست خیریه‌ها</h3>
            <p class="text-gray-500 text-sm mt-1">مدیریت و بررسی خیریه‌های ثبت‌نام شده</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.charities.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200 {{ !request('status') ? 'bg-green-100 text-green-700' : '' }}">همه</a>
            <a href="{{ route('admin.charities.index', ['status' => 'pending']) }}" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200 {{ request('status') === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}">در انتظار تأیید</a>
            <a href="{{ route('admin.charities.index', ['status' => 'approved']) }}" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200 {{ request('status') === 'approved' ? 'bg-green-100 text-green-700' : '' }}">تأیید شده</a>
        </div>
    </div>

    <div class="p-6">
        <form method="GET" class="mb-4">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجو بر اساس نام یا شماره ثبت..." 
                       class="w-full border border-gray-300 rounded-lg p-3 pr-10">
                <button type="submit" class="absolute left-3 top-3 text-gray-400">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">نام خیریه</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">مدیرعامل</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">شماره ثبت</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">شهر</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">وضعیت</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($charities as $charity)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-building text-green-600"></i>
                                </div>
                                <span class="font-bold">{{ $charity->user->name ?? 'بدون نام' }}</span>
                            </div>
                        </td>
                        <td class="p-3">{{ $charity->manager_name ?? '-' }}</td>
                        <td class="p-3">{{ $charity->registration_number ?? '-' }}</td>
                        <td class="p-3">{{ $charity->user->city ?? '-' }}</td>
                        <td class="p-3">
                            @if($charity->is_approved)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">تأیید شده</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">در انتظار</span>
                            @endif
                            
                            @if($charity->user && !$charity->user->is_active)
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs mr-1">غیرفعال</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.charities.show', $charity->id) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!$charity->is_approved)
                                    <form method="POST" action="{{ route('admin.charities.approve', $charity->id) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.charities.reject', $charity->id) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.charities.toggle-active', $charity->id) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="{{ $charity->user && $charity->user->is_active ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }}">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $charities->links() }}
        </div>
    </div>
</div>
@endsection