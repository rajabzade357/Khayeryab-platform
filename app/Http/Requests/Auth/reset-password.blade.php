<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">تعیین رمز عبور جدید</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">رمز عبور جدید</label>
                <input type="password" name="password" class="w-full border rounded-lg p-3" required minlength="6">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">تکرار رمز عبور</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg p-3" required>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg">ذخیره رمز جدید</button>
        </form>
    </div>
</x-guest-layout>