<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">ورود مدیریت</h2>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">ایمیل</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full border rounded-lg p-3" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">رمز عبور</label>
                <input type="password" name="password" 
                       class="w-full border rounded-lg p-3" required>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-lg">
                ورود به پنل مدیریت
            </button>
        </form>
    </div>
</x-guest-layout>