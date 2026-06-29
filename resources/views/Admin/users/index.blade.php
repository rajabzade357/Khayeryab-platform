@extends('admin.layouts.admin')

@section('title', 'مدیریت کاربران')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h3 class="text-xl font-bold text-gray-800">همه کاربران</h3>
        <div class="flex gap-2 mt-3">
            <a href="{{ route('admin.users.index') }}" class="px-3 py-1 rounded-lg text-sm {{ !request('role') ? 'bg-green-600 text-white' : 'bg-gray-100' }}">همه</a>
            <a href="{{ route('admin.users.index', ['role' => 'donor']) }}" class="px-3 py-1 rounded-lg text-sm {{ request('role') === 'donor' ? 'bg-blue-600 text-white' : 'bg-gray-100' }}">خیرها</a>
            <a href="{{ route('admin.users.index', ['role' => 'charity']) }}" class="px-3 py-1 rounded-lg text-sm {{ request('role') === 'charity' ? 'bg-green-600 text-white' : 'bg-gray-100' }}">خیریه‌ها</a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="px-3 py-1 rounded-lg text-sm {{ request('role') === 'admin' ? 'bg-purple-600 text-white' : 'bg-gray-100' }}">ادمین‌ها</a>
        </div>
    </div>

    <div class="p-6">
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجو..." class="flex-1 border rounded-lg p-2">
            <select name="status" class="border rounded-lg p-2">
                <option value="">همه وضعیت‌ها</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>فعال</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>غیرفعال</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">فیلتر</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-right">نام</th>
                        <th class="p-3 text-right">نقش</th>
                        <th class="p-3 text-right">موبایل</th>
                        <th class="p-3 text-right">شهر</th>
                        <th class="p-3 text-right">وضعیت</th>
                        <th class="p-3 text-right">تاریخ عضویت</th>
                        <th class="p-3 text-right">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 {{ !$user->is_active ? 'bg-red-50' : '' }}">
                        <td class="p-3 font-bold">{{ $user->name }}</td>
                        <td class="p-3">
                            @if($user->role === 'admin') <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">ادمین</span>
                            @elseif($user->role === 'charity') <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">خیریه</span>
                            @else <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">خیر</span>
                            @endif
                        </td>
                        <td class="p-3">{{ $user->mobile ?? '-' }}</td>
                        <td class="p-3">{{ $user->city ?? '-' }}</td>
                        <td class="p-3">
                            @if($user->is_active)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">فعال</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">غیرفعال</span>
                            @endif
                        </td>
                        <td class="p-3 text-sm">{{ $user->created_at->format('Y/m/d') }}</td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600"><i class="fas fa-eye"></i></a>
                                <form method="POST" action="{{ route('admin.users.toggle-active', $user->id) }}" class="inline">
                                    @csrf @method('PUT')
                                    <button class="{{ $user->is_active ? 'text-red-600' : 'text-green-600' }}"><i class="fas fa-power-off"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</div>
@endsection