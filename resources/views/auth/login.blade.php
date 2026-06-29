<x-guest-layout>
   

    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">ورود به حساب</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- شماره همراه -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">
                    <i class="fas fa-mobile-alt ml-1 text-gray-400"></i>
                    شماره همراه
                </label>
                <input type="text" name="mobile" value="{{ old('mobile') }}" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500" 
                       placeholder="۰۹۱۲۳۴۵۶۷۸۹" required autofocus>
                @error('mobile')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- رمز عبور -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">
                    <i class="fas fa-lock ml-1 text-gray-400"></i>
                    رمز عبور
                </label>
                <input type="password" name="password" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500" 
                       placeholder="••••••••" required>
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- یادآوری و فراموشی رمز -->
            <div class="flex justify-between items-center mb-6">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-green-600 rounded">
                    <span class="text-sm text-gray-600">مرا به خاطر بسپار</span>
                </label>
            </div>

            <!-- دکمه ورود -->
            <button type="submit" 
                    class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition">
                ورود
            </button>
            <div class=" mt-4"> 
             <a href="{{ route('password.request.mobile') }}" class="text-sm text-green-600 hover:underline">
                        رمز عبور را فراموش کرده‌اید؟<br>
                    </a>
            </div>
            
            <!-- لینک ثبت‌نام -->
            <div class="text-center mt-6"> 
                <p class="text-gray-600">
                    حساب کاربری ندارید؟
                    <a href="{{ route('register.donor') }}" class="text-green-600 font-bold hover:underline">
                        ثبت‌نام کنید
                    </a>
                </p>
                <p class="text-gray-500 text-sm mt-2">
                    <a href="{{ route('register.charity') }}" class="text-green-600 hover:underline">
                        ثبت‌نام خیریه
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>