@extends('admin.layouts.admin')

@section('title', 'مدیریت خیرها')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b flex flex-col md:flex-row justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">لیست خیرها</h3>
            <p class="text-gray-500 text-sm mt-1">مدیریت خیرهای ثبت‌نام شده</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.donors.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200 {{ !request('status') ? 'bg-green-100 text-green-700' : '' }}">همه</a>
            <a href="{{ route('admin.donors.index', ['status' => 'active']) }}" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">فعال</a>
            <a href="{{ route('admin.donors.index', ['status' => 'inactive']) }}" class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200">غیرفعال</a>
        </div>
    </div>

    <div class="p-6">
        <form method="GET" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجو بر اساس نام یا شماره ..." 
                   class="w-full border border-gray-300 rounded-lg p-3">
        </form>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">نام</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">شماره</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">شهر</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">تخلفات</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">وضعیت</th>
                        <th class="p-3 text-right text-sm font-bold text-gray-600">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($donors as $donor)
                    <tr class="hover:bg-gray-50 {{ !$donor->is_active ? 'bg-red-50' : '' }}">
                        <td class="p-3 font-bold">{{ $donor->name }}</td>
                        <td class="p-3">{{ $donor->mobile ?? '-' }}</td>
                        <td class="p-3">{{ $donor->city ?? '-' }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                {{ $donor->violation_count == 0 ? 'bg-green-100 text-green-700' : '' }}
                                {{ $donor->violation_count > 0 && $donor->violation_count < 3 ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $donor->violation_count >= 3 ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $donor->violation_count }}
                            </span>
                        </td>
                        <td class="p-3">
                            @if($donor->is_active)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">فعال</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">غیرفعال</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.donors.show', $donor->id) }}" class="text-blue-600">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.donors.toggle-active', $donor->id) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="{{ $donor->is_active ? 'text-red-600' : 'text-green-600' }}">
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
            {{ $donors->links() }}
        </div>
    </div>
</div>
@endsection