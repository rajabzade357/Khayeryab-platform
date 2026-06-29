<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>پنل مدیریت | خیّر‌یاب</title>
    
    <!-- Tailwind + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Chart.js برای نمودار -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700;900&display=swap');
        
        * {
            font-family: 'Vazirmatn', sans-serif ;
             font-size: 0.875rem;
        }
        
        .sidebar {
            transition: all 0.3s;
        }
        
        .sidebar-link {
            transition: all 0.2s;
        }
        
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }
        
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            border-right: 3px solid #fff;
        }
    </style>
</head>
<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z' fill='%23ef4444'/%3E%3C/svg%3E"></head>

<body class="bg-green-200">
    
    <!-- دکمه منوی موبایل -->
    <button id="menu-toggle" class="fixed top-4 right-4 z-50 lg:hidden bg-green-700 text-white p-2 rounded-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- سایدبار -->
    <aside id="sidebar" class="sidebar fixed top-0 right-0 h-full w-64 bg-gradient-to-b from-green-800 to-gray-900 text-white transform translate-x-full lg:translate-x-0 transition-transform z-40 overflow-y-auto">
        <div class="p-6 border-b border-gray-700">
            <h1 class="text-2xl font-bold">
                <i class="fas fa-crown ml-2 text-yellow-400"></i>
                پنل مدیریت
            </h1>
            <p class="text-green-300 text-sm mt-1">خیّر‌یاب</p>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-tachometer-alt w-5 text-center"></i>
                <span>گزارشات</span>
            </a>

            <div class="pt-4 pb-2 text-green-300 text-xs font-bold px-4">مدیریت</div>

            <a href="{{ route('admin.charities.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.charities.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-building w-5 text-center"></i>
                <span>خیریه‌ها</span>
            </a>

            <a href="{{ route('admin.donors.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.donors.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-hand-holding-heart w-5 text-center"></i>
                <span>خیرها</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span>همه کاربران</span>
            </a>

            <a href="{{ route('admin.donations.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.donations.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-gift w-5 text-center"></i>
                <span>کمک‌ها</span>
            </a>

            <div class="pt-4 pb-2 text-green-300 text-xs font-bold px-4">ابزارها</div>

           

            <a href="{{ route('admin.settings.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-lg transition {{ request()->routeIs('admin.settings.*') ? 'active bg-white/20 border-r-2 border-white' : '' }}">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>تنظیمات</span>
            </a>

            <div class="pt-4 mt-4 border-t border-green-700">
                <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-green-300 hover:text-white transition">
                    <i class="fas fa-arrow-right w-5 text-center"></i>
                    <span>بازگشت به سایت</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full flex items-center gap-3 px-4 py-3 text-red-300 hover:text-red-200 transition">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span>خروج</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- محتوای اصلی -->
    <main class="lg:mr-64 min-h-screen">
        <!-- هدر -->
        <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800">@yield('title', 'داشبورد')</h2>
                <p class="text-sm text-gray-500">{{ Auth::user()->name }} | ادمین</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                    <i class="fas fa-circle text-green-500 text-xs ml-1"></i>
                    آنلاین
                </span>
            </div>
        </header>

        <!-- محتوا -->
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
                    <i class="fas fa-check-circle ml-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
                    <i class="fas fa-exclamation-circle ml-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Overlay برای موبایل -->
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const menuToggle = document.getElementById('menu-toggle');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
        });

        function closeSidebar() {
            sidebar.classList.add('translate-x-full');
            overlay.classList.add('hidden');
        }
    </script>
</body>
</html>