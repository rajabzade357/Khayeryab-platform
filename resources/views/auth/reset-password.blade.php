<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">تعیین رمز عبور جدید</h2>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">
                    <i class="fas fa-lock ml-1 text-gray-400"></i>
                    رمز عبور جدید
                </label>
                <input type="password" name="password" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500" 
                       placeholder="حداقل ۶ کاراکتر" required minlength="6">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">
                    <i class="fas fa-lock ml-1 text-gray-400"></i>
                    تکرار رمز عبور جدید
                </label>
                <input type="password" name="password_confirmation" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500" 
                       placeholder="تکرار رمز عبور" required>
            </div>

            <button type="submit" 
                    class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-save ml-2"></i>
                ذخیره رمز جدید
            </button>
        </form>
    </div>
</x-guest-layout>