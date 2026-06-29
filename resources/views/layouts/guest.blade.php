<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('title', 'خیّر‌یاب') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- TailwindCSS & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;700&display=swap');
        body { font-family: 'Vazirmatn', sans-serif;
               font-size: 0.8rem;
             }
    </style>
</head>

<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z' fill='%23ef4444'/%3E%3C/svg%3E"></head>


<body class="bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('images/login-bg.png') }}');">
    
    <div class="min-h-screen bg-black/30">
        
  <header class="bg-gray-800 shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-green-400">خیّر‌یاب</a>
            <div class="text-white text-sm hidden md:block">
                <i class="fas fa-hand-holding-heart ml-1"></i>
                فضلی به وسعت شهر
            </div>
        </div>
    </div>
</header>

        <!-- محتوای اصلی (فرم در سمت راست) -->
        <div class="flex min-h-[calc(100vh-80px)]">
            <!-- سمت چپ: خالی -->
            <div class="hidden md:block md:w-1/2"></div>

            <!-- سمت راست: فرم -->
            <div class="w-full md:w-1/2 flex items-center justify-center px-6 py-12">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>

   <!-- فوتر -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- ستون اول: نام و توضیح -->
                <div>
                    <h3 class="text-2xl font-bold text-green-400 mb-4">خیّر‌یاب</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        تسهیل اهدای لوازم به خیریه‌های معتبر
                    </p>
                    <p class="text-gray-300 text-sm leading-relaxed">
                         با ما در کار خیر سهیم باشید
                    </p>
                </div>

                <!-- ستون دوم: دسترسی سریع -->
                <div>
                    <h4 class="text-lg font-bold mb-4">دسترسی سریع</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}" class="text-gray-300 hover:text-green-400 transition">صفحه اصلی</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-green-400 transition">درباره ما</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-green-400 transition">تماس با ما</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-green-400 transition">سوالات متداول</a></li>
                    </ul>
                </div>

                <!-- ستون سوم: اطلاعات تماس -->
                <div>
                    <h4 class="text-lg font-bold mb-4">تماس با ما</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt w-5 text-green-400"></i>
                            <span>تهران، خیابان ولیعصر، پلاک ۱۲۳</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone w-5 text-green-400"></i>
                            <span>۰۲۱-۱۲۳۴۵۶۷۸</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope w-5 text-green-400"></i>
                            <span>info@kheiryab.ir</span>
                        </li>
                    </ul>
                </div>

                <!-- ستون چهارم: شبکه‌های اجتماعی -->
                <div>
                    <h4 class="text-lg font-bold mb-4">ما را دنبال کنید</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-green-500 transition">
                            <i class="fab fa-telegram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-green-500 transition">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-green-500 transition">
                            <i class="fab fa-linkedin-in text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-green-500 transition">
                            <i class="fab fa-whatsapp text-white"></i>
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
                <p>© 1405 - تمامی حقوق برای <span class="text-green-400">خیّر‌یاب</span> محفوظ است.</p>
                <p class="mt-1">طراحی و توسعه توسط Topaz </p>
            </div>
        </div>
    </footer>
        
    </div>
</body>
</html>