@extends('admin.layouts.admin')

@section('title', 'تنظیمات')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- مدیریت ادمین‌ها -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">مدیریت ادمین‌ها</h3>
        
        <form method="POST" action="{{ route('admin.settings.add-admin') }}" class="space-y-3 mb-6">
            @csrf
            <div>
                <label class="block text-sm font-bold mb-1">نام</label>
                <input type="text" name="name" class="w-full border rounded-lg p-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">ایمیل</label>
                <input type="email" name="email" class="w-full border rounded-lg p-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">رمز عبور</label>
                <input type="password" name="password" class="w-full border rounded-lg p-2" required minlength="6">
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-plus ml-1"></i> افزودن ادمین
            </button>
        </form>

        <div class="space-y-2">
            @foreach($admins as $admin)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-bold">{{ $admin->name }}</p>
                    <p class="text-sm text-gray-500">{{ $admin->email }}</p>
                </div>
                @if($admins->count() > 1)
                <form method="POST" action="{{ route('admin.settings.remove-admin', $admin->id) }}">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                </form>
                @endif
            </div>
            @endforeach
        </div>
    </div>


</div>
@endsection