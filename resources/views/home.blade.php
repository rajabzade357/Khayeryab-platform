@extends('layouts.app')

@section('title', 'خیّر‌یاب | اهدای لوازم به خیریه‌ها')

@push('styles')
<style>
    
    .rainbow-bg {
        min-height: 100vh;
        background: linear-gradient(270deg, #ff5f5f, #44ccc3, #d1458d, #94cb34, #f924e4, #ff6b6b);
        background-size: 300% 300%;
        animation: gradientMove 12s ease infinite;
    }
    
    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* محتوای اصلی  */
    .content-wrapper {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
    }
    
    /* بنر بالای صفحه */
    .top-banner {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        position: relative;
        overflow: hidden;
    }
    
    .top-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: float 20s linear infinite;
    }
    
    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(-50px, -50px) rotate(5deg); }
    }
    
    /* بنر پایینی  */
    .bottom-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }
    
    .bottom-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>
@endpush

@section('content')
<div class="rainbow-bg">
    
    <!-- ========== بنر بالای صفحه ========== -->
    <div class="top-banner pt-24 pb-16 px-6">
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-5xl font-bold text-white mb-4">خیّر‌یاب</h2>
            <p class="text-white text-xl mb-2 opacity-95">
                تسهیل ارتباط خیریه‌ها و نیکوکاران
            </p>
            <p class="text-white text-lg opacity-80">
                لوازم مازاد خود را به دست نیازمندان برسانید
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('register.donor') }}" class="bg-white text-pink-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition shadow-lg">
                    <i class="fas fa-heart ml-2"></i>
                    می‌خواهم اهدا کنم
                </a>
            </div>
        </div>
    </div>
    <!-- ============================================== -->
    
    <div class="content-wrapper" id="more">
        
        <!--بخش اول -->
        <div class="max-w-7xl mx-auto px-6 pt-16 pb-12">
            <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                
                <div class="md:w-5/12 flex justify-center">
                    <img src="{{ asset('images/s1.png') }}" alt="اهدای لوازم" 
                         class="rounded-2xl shadow-2xl w-full max-w-md object-cover object-center"
                         style="height: 380px;">
                </div>
                
                <div class="md:w-5/12 text-right">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">خیّر‌یاب</h2>
                    <p class="text-gray-700 leading-relaxed">  این سامانه با هدف ایجاد بستری مطمئن و ساده برای ارتباط میان مردم و مجموعه‌های خیریه راه‌اندازی شده است تا فرآیند حمایت، مشارکت و اطلاع‌رسانی با سرعت و شفافیت بیشتری انجام شود.
                        <br><br>
                        در این بستر، خیریه‌ها می‌توانند فعالیت‌ها، نیازها و طرح‌های حمایتی خود را معرفی کنند و کاربران نیز با مجموعه‌های فعال در حوزه‌های مختلف آشنا شوند و در مسیر کمک‌رسانی مشارکت داشته باشند.
                        <br><br>
                        همه‌ی خیریه ها توسط مدیریت درستی سنجی شده و شماره ثبت‌شان برای اطمینان خاطر خیّرین محترم موجود است
                        <br><br>
                        هدف ما فراهم‌کردن فضایی است که ارتباط میان خیرین، داوطلبان و مؤسسات خیریه را آسان‌تر کند و دسترسی به اطلاعات و خدمات مرتبط را در یک سامانه واحد در اختیار کاربران قرار دهد.
                    </p>
                </div>
                
            </div>
        </div>

        <div class="h-[2px] bg-gradient-to-r from-transparent via-gray-400 to-transparent max-w-7xl mx-auto"></div>

        <!-- بخش دوم -->
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row-reverse items-center justify-center gap-8">
                
                <div class="md:w-5/12 flex justify-center">
                    <img src="{{ asset('images/s2.png') }}" alt="خیریه‌ها" 
                         class="rounded-2xl shadow-2xl w-full max-w-md object-cover object-center"
                         style="height: 380px;">
                </div>
                
                <div class="md:w-5/12 text-right">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">اهداکنندگان محترم</h2>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        شما می‌توانید با ثبت‌نام در سامانه، نیازمندی خیریه ها را مشاهده نموده و  لوازم مازاد خود را به خیریه‌های معتبر شهرتان اهدا کنید.<br>
                        پس از ورود به پنل کاربری، با تکمیل فرم اهدا شامل عنوان، توضیحات و انتخاب روش تحویل، درخواست اهدای خود را ثبت می‌نمایید.<br>
                       برای تحویل لوازم، دو روش تحویل «تحویل در محل خیریه» و «دریافت از منزل اهداکننده» در نظر گرفته شده است.<br>
                       همچین قادر خواهید بود با مشاهده‌ی حساب رسمی خیریه ها، مبالغ موردنظرتان را به خیریه های دلخواه اهدانمایید.<br>
                    </p>
                    <a href="{{ route('register.donor') }}" class="inline-block bg-blue-300 text-black px-6 py-3 rounded-lg hover:bg-blue-100 transition shadow-md">
                        ثبت‌نام خیّر
                    </a>

                    <div class="mt-10 pt-6 border-t border-gray-200"></div>

                    <h2 class="text-3xl font-bold text-gray-800 mb-4">مؤسسات خیریه</h2>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        خیریه‌ها با ورود به سامانه، فهرست اهداهای مربوط به خود را مشاهده کرده و هر درخواست را «تأیید» یا «رد» می‌نمایند.
                        همچنین قادر خواهند بود وسایل ترجیحی و نیازمندی های مالی خیریه را تعیین کرده تا اهداکنندگان متناسب با نیاز اقدام نمایند.
                    </p>
                    <a href="{{ route('register.charity') }}" class="inline-block bg-blue-300 text-black px-6 py-3 rounded-lg hover:bg-blue-100 transition shadow-md">
                        ثبت‌نام خیریه
                    </a>
                </div>
                
            </div>
        </div>
        
    </div>
    
    <!-- ========== بنر پایین  ========== -->
    <div class="bottom-banner py-16 px-6">
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-4xl font-bold text-white mb-4">چطور به خیّریاب اعتماد کنیم؟</h2>
            <p class="text-white text-lg mb-8 opacity-90">
کلیه ی خیریه ها ‌ی فعال در خیّریاب دارای مجوز فعال از وزارت کشور بوده و تحت نظارت بهزیستی هستند <br> صحت مدارک و اطلاعات خیریه ها توسط مدیریت بررسی و تایید میشود  <br> همچنین شماره ثبت و مجوز خیریه های فعال برای اطمینان خیّرین قابل مشاهده و پیگیری میباشد          </p>
            <div class="flex flex-wrap justify-center gap-4">
               
                <a href="{{ route('charities.index') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-purple-700 transition">
                    
                    مشاهده خیریه‌ها
                </a>
            </div>
        </div>
    </div>
    <!-- ============================================== -->
    
</div>
@endsection