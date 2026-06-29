<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'خیّر‌یاب')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;700&display=swap');
        * { font-family: 'Vazirmatn', sans-serif; 
            font-size: 0.9rem;
        }

        @keyframes gradient {
           0% { background-position: 0% 50%; }
           50% { background-position: 100% 50%; }
           100% { background-position: 0% 50%; }
        }

        /* منوی همبرگری */
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            width: 280px;
            height: 100%;
            background: linear-gradient(135deg, #166534 0%, #ec4899 100%);
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            color: white !important;
        }

        #sidebar a,#sidebar span,#sidebar i,#sidebar h2,#sidebar p {
            color: white !important;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 999;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        .sidebar-item:hover {
            color: #7fd49f
        }
        
        
        header {
            transition: all 0.3s ease;
        }
        header.hidden-header {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-100%);
        }
        #sidebar h2 {
           color: white !important;
        }
        #sidebar hr {
        border-color: rgba(255,255,255,0.2);
        }


    </style>
    
    @stack('styles')


   <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z' fill='%23ef4444'/%3E%3C/svg%3E"></head>
   <body class="min-h-screen flex flex-col bg-gradient-to-br from-green-100 to-blue-150">
   <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md transition-all duration-300">
     <div class="container mx-auto px-4 py-5 flex justify-between items-center">
        
        <!-- بخش سمت چپ  -->
        <div class="flex items-center gap-6">
            
            <!-- منو همبرگری -->
            <button onclick="toggleSidebar()" class="flex flex-col gap-1.5 p-2">
                <div class="w-7 h-0.5 bg-green-800"></div>
                <div class="w-7 h-0.5 bg-green-800"></div>
                <div class="w-7 h-0.5 bg-green-800"></div>
            </button>

            <!-- لوگو -->
            <a href="{{ url('/') }}" class="block">
                <img src="{{ asset('images/icon1.png') }}" alt="خیّر‌یاب" class="h-12 w-auto object-contain">
            </a>
            
            <!-- لینک‌های افقی -->
            <div class="flex items-center gap-6">
                
                @guest
                   
                    <div class="flex flex-col items-start gap-1">
                        <a href="{{ route('register.donor') }}" class="text-green-800 hover:text-green-600 transition font-medium text-sm">
                            ثبت‌نام خیر
                        </a>
                        <a href="{{ route('register.charity') }}" class="text-green-800 hover:text-green-600 transition font-medium text-sm">
                            ثبت‌نام خیریه
                        </a>
                    </div>
                     <a href="{{ route('login') }}" class="text-green-800 hover:text-green-600 transition font-medium text-sm">
                        ورود
                    </a>
                @else
                    <div class="flex flex-col items-start gap-1">
                        <div class="text-green-800 font-medium text-sm">
                             @php
        $dashboardRoute = match(Auth::user()->role) {
            'admin' => 'admin.dashboard',
            'charity' => 'charity.dashboard',
            default => 'donor.dashboard',
        };
    @endphp
    <a href="{{ route($dashboardRoute) }}" class="...">
        {{ Auth::user()->name }}
    </a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 transition font-medium text-sm">
                                خروج
                            </button>
                        </form>
                    </div>
                @endguest
                <a href="{{ route('charities.index') }}" class="text-green-800 hover:text-green-600 transition font-medium text-sm">
                    خیریه‌های فعال
                </a>
                <a href="{{ route('faq') }}" class="text-green-800 hover:text-green-600 transition font-medium text-sm">
                    سوالات متداول
                </a>
            </div>
        </div>
        
        <!-- بخش سمت راست  -->
        <div class="text-green-800 text-sm hidden md:block">
            <i class="fas fa-hand-holding-heart ml-1"></i>
            فضلی به وسعت شهر
        </div>
        
    </div>
</header>

  <!--  سایدبار -->
<div id="sidebar" class="sidebar">
    <div class="p-6 border-b">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">منو</h2>
            <button onclick="toggleSidebar()" class="text-gray-400 hover:text-gray-600">
               
            </button>
        </div>
    </div>
    <nav class="p-4 space-y-2">
        
        <!-- ====== لینک‌های عمومی  ====== -->
        <a href="{{ url('/') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
            <span>صفحه اصلی</span>
        </a>

        <!-- ====== کاربر لاگین   ====== -->
        @auth
            @if(Auth::user()->role === 'charity')
                <!-- ====== نقش خیریه ====== -->
                <a href="{{ route('charity.dashboard') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-tachometer-alt w-5 text-gray-500"></i>
                    <span>داشبورد</span>
                </a>
                <a href="{{ route('charity.profile') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-building w-5 text-gray-500"></i>
                    <span>پروفایل خیریه</span>
                </a>
                <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-heart w-5 text-gray-500"></i>
                    <span>وسایل ترجیحی</span>
                </a>
                <hr class="my-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition text-red-600 w-full">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>خروج</span>
                    </button>
                </form>

            @elseif(Auth::user()->role === 'donor')
                <!-- ====== نقش خیر ====== -->
                <a href="{{ route('donor.dashboard') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-tachometer-alt w-5 text-gray-500"></i>
                    <span>داشبورد</span>
                </a>
                <a href="{{ route('donor.profile') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-user w-5 text-gray-500"></i>
                    <span>پروفایل</span>
                </a>
                <a href="#" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                    <i class="fas fa-gift w-5 text-gray-500"></i>
                    <span>اهدای جدید</span>
                </a>
                <hr class="my-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition text-red-600 w-full">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>خروج</span>
                    </button>
                </form>

            @elseif(Auth::user()->role === 'admin')
                <!-- ====== نقش ادمین ====== -->
                 <nav class="p-4 space-y-1">
                 <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-black hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                 <i class="fas fa-tachometer-alt w-5 text-center"></i>
                 <span>گزارشات</span>
            </a>

            <div class="pt-4 pb-2 text-green-700 text-xs font-bold px-4">مدیریت</div>

            <a href="{{ route('admin.charities.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-black hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.charities.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-building w-5 text-center"></i>
                <span>خیریه‌ها</span>
            </a>

            <a href="{{ route('admin.donors.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-black hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.donors.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-hand-holding-heart w-5 text-center"></i>
                <span>خیرها</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-black hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span>همه کاربران</span>
            </a>

            <a href="{{ route('admin.donations.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-black hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.donations.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-gift w-5 text-center"></i>
                <span>کمک‌ها</span>
            </a>

            <div class="pt-4 pb-2 text-green-700 text-xs font-bold px-4">ابزارها</div>

           

            <a href="{{ route('admin.settings.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-black hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.settings.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>تنظیمات</span>
            </a>

            <div class="pt-4 mt-4 border-t border-green-700">
                <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-green-700 hover:text-white transition">
                    <i class="fas fa-arrow-right w-5 text-center"></i>
                    <span>بازگشت به سایت</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-red-700 hover:text-red-200 transition">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span>خروج</span>
                    </button>
                </form>
            </div>
            </nav>
            @endif

        <!-- ====== کاربر مهمان ====== -->
        @else
            <a href="{{ route('login') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                <span>ورود</span>
            </a>
            <a href="{{ route('register.donor') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                <span>ثبت‌نام خیر</span>
            </a>
            <a href="{{ route('register.charity') }}" class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition">
                <span>ثبت‌نام خیریه</span>
            </a>
        @endauth

    </nav>
</div>
        <div id="overlay" class="overlay" onclick="closeSidebar()"></div>


    <!-- محتوای اصلی -->
    <main class="flex-1 pt-20">
        @yield('content')
    </main>

    <!-- فوتر -->
    <footer class=" bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- ستون اول -->
                <div>
                    <h3 class="text-2xl font-bold text-green-400 mb-4">خیّر‌یاب</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        تسهیل اهدای لوازم به خیریه‌های معتبر
                    </p>
                    <p class="text-gray-300 text-sm leading-relaxed">
                         با ما در کار خیر سهیم باشید
                    </p>
                </div>

                <!-- ستون دوم -->
                <div>
                    <h4 class="text-lg font-bold mb-4">دسترسی سریع</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}" class="text-gray-300 hover:text-green-400 transition">صفحه اصلی</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-green-400 transition">درباره ما</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-green-400 transition">تماس با ما</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-green-400 transition">سوالات متداول</a></li>
                    </ul>
                </div>

                <!-- ستون سوم   -->
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

                <!-- ستون چهارم   -->
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

            <!-- خط  -->
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
                <p>© 1405 - تمامی حقوق برای <span class="text-green-400">خیّر‌یاب</span> محفوظ است.</p>
                <p class="mt-1">طراحی و توسعه توسط Topaz </p>
            </div>
        </div>
    </footer>

    <script>
       // هدر متحرک
       const header = document.querySelector('header');
       const scrollThreshold = window.innerHeight / 2;
    
       window.addEventListener('scroll', () => {
           if (window.scrollY > scrollThreshold) {
               header.classList.add('hidden-header');
            } else {
               header.classList.remove('hidden-header');
            }
        });
    
       // سایدبار 
       const sidebar = document.getElementById('sidebar');
       const overlay = document.getElementById('overlay');

       function toggleSidebar() {
           sidebar.classList.toggle('open');
           overlay.classList.toggle('show');
        }

       function closeSidebar() {
           sidebar.classList.remove('open');
          overlay.classList.remove('show');
        }

       // کلیک روی overlay بسته بشه
       overlay.addEventListener('click', closeSidebar);
    </script>
   
    @stack('scripts')
</body>
</html>