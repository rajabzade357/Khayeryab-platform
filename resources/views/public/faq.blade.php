@extends('layouts.app')

@section('title', 'سوالات متداول')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-200 to-blue-200 py-8">
   
        
<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">سوالات متداول</h1>
        
    </div>

    {{-- تب‌ها --}}
    <div class="flex justify-center gap-2 mb-8">
        <button onclick="showTab('donor')" id="tab-donor" 
                class="px-6 py-3 rounded-lg font-bold transition bg-green-700 text-white">
             خیّرین
        </button>
        <button onclick="showTab('charity')" id="tab-charity" 
                class="px-6 py-3 rounded-lg font-bold transition bg-gray-300 text-gray-700">
            خیریه‌ها
        </button>
    </div>

    {{-- سوالات خیرین --}}
    <div id="donor-faq" class="space-y-4">
        @php $donorFaqs = [
            ['q' => 'چطور ثبت‌نام کنم؟', 'a' => 'بالای صفحه روی "ثبت‌نام خیر" کلیک کنین. نام، رمز عبور، شهر، آدرس و تلفن رو وارد کنین. بعد شماره موبایلتون رو تأیید کنین. !'],
            ['q' => 'چطور یه وسیله اهدا کنم؟', 'a' => 'وارد داشبورد بشین. توی "ثبت اهدای جدید"، عنوان وسیله، توضیحات، دسته‌بندی (کوچک یا بزرگ)، خیریه مقصد، روش تحویل و تاریخ رو وارد کنین. درخواستتون برای خیریه ارسال میشه.'],
            ['q' => 'روش‌های تحویل چیا هستن؟', 'a' => 'دو روش داریم: <br>• <b>تحویل در محل خیریه:</b> خودتون وسیله رو به خیریه میبرین<br>• <b>تحویل به خودرو خیریه:</b> خیریه ماشین میفرسته درب منزل شما'],
            ['q' => 'بعد از ثبت اهدا چی میشه؟', 'a' => 'درخواست به خیریه ارسال میشه. اونا بررسی میکنن و تأیید یا رد میکنن. وضعیت اهدا رو توی داشبوردتون میتونین دنبال کنین.'],
            ['q' => 'چرا اهدای من رد شد؟', 'a' => 'خیریه میتونه به دلایلی مثل "پاسخگو نبودن" یا "نامناسب بودن جنس" درخواست رو رد کنه. .'],
            ['q' => 'امتیاز منفی چیه؟', 'a' => 'فقط وقتی که اهدا تأیید بشه ولی شما تحویل ندین، امتیاز منفی ثبت میشه. .'],
            ['q' => 'چطور خیریه معتبر پیدا کنم؟', 'a' => 'همه خیریه‌های موجود توی سایت توسط مدیریت تأیید شدن. میتونین از صفحه "خیریه‌ها" لیستشون رو ببینین، شهرشون رو فیلتر کنین و وسایل مورد نیازشون رو چک کنین.'],
            ['q' => 'میتونم به چه خیریه کمک کنم؟', 'a' => 'به هر خیریه که در شهر شما باشه میتونید اهداکنین.'],
            ['q' => 'چطور بفهمم خیریه چی نیاز داره؟', 'a' => 'توی صفحه هر خیریه، بخش "وسایل ترجیحی" رو ببینین. اونجا نوشته چه چیزایی بیشتر نیاز دارن.'],
            ['q' => 'اطلاعات من کجا نمایش داده میشه؟', 'a' => 'نام، آدرس و شماره تماس شما فقط برای خیریه‌ای که بهش اهدا کردین نمایش داده میشه. .'],
           
        ]; @endphp

        @foreach($donorFaqs as $faq)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <button onclick="toggleFaq(this)" class="w-full flex justify-between items-center p-5 text-right hover:bg-gray-50 transition">
                <span class="font-bold text-gray-800">{{ $faq['q'] }}</span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-gray-600 leading-relaxed">
                {!! $faq['a'] !!}
            </div>
        </div>
        @endforeach
    </div>

    {{-- سوالات خیریه‌ها --}}
    <div id="charity-faq" class="space-y-4 hidden">
        @php $charityFaqs = [
            ['q' => 'چطور خیریه ثبت‌نام کنم؟', 'a' => 'بالای صفحه روی "ثبت‌نام خیریه" کلیک کنین. اطلاعات خیریه شامل نام، مدیرعامل، شهر، آدرس، شماره ثبت، شناسه ملی، شماره پروانه فعالیت، تصویر پروانه، تصویر کارت ملی، شماره حساب، شبا و رمز عبور رو وارد کنین. بعد شماره موبایلتون رو تأیید کنین.'],
            ['q' => 'چرا خیریه من توی لیست عمومی نیست؟', 'a' => 'خیریه شما باید توسط مدیریت تأیید بشه. بعد از بررسی مدارک، تأیید میشه و توی لیست خیریه‌ها نمایش داده میشه.'],
            ['q' => 'تأیید مدارک چقدر طول میکشه؟', 'a' => 'مدیریت در اسرع وقت مدارک رو بررسی میکنه. معمولاً ۲۴ تا ۴۸ ساعت.'],
            ['q' => 'چطور اهداهای دریافتی رو مدیریت کنم؟', 'a' => 'وارد داشبورد بشین. توی جدول "مدیریت اهداها"، هر درخواست رو میتونین تأیید یا رد کنین. بعد از تأیید، وضعیت تحویل رو هم میتونین ثبت کنین.'],
            ['q' => 'وضعیت‌های اهدا یعنی چی؟', 'a' => '<b>در انتظار بررسی:</b> اهدای جدید که هنوز تصمیمی براش نگرفتین<br><b>منتظر خیر:</b> تأیید کردین و منتظرین خیر تحویل بده<br><b>منتظر خودرو:</b> تأیید کردین و باید ماشین بفرستین<br><b>تحویل داده شد:</b> خیر تحویل داده<br><b>خودرو تحویل گرفت:</b> ماشین شما وسیله رو گرفته<br><b>تحویل داده نشد:</b> خیر تحویل نداده (امتیاز منفی)<br><b>رد شده:</b> درخواست رو رد کردین'],
            ['q' => 'اگه خیّر تحویل نده چی؟', 'a' => 'گزینه "تحویل داده نشد" رو بزنین و دلیلش رو انتخاب کنین (پاسخگو نبود یا جنس نامناسب). این کار برای خیر امتیاز منفی ثبت میکنه.'],
            ['q' => 'میتونم تصمیمم رو عوض کنم؟', 'a' => 'بله. تا وقتی اهدا به مرحله نهایی نرسیده، میتونین تأیید یا رد رو لغو کنین.'],
            ['q' => 'وسایل ترجیحی چیه؟', 'a' => 'لیستی از وسایلی که خیریه بیشتر نیاز داره. توی داشبوردتون میتونین اضافه و حذف کنین. این لیست توی صفحه عمومیتون به خیرین نشون داده میشه.'],
            ['q' => 'اگه اطلاعات خیریه رو عوض کنم چی میشه؟', 'a' => 'تغییر اطلاعات حساس (مثل شماره ثبت، شناسه ملی، مدیرعامل) باعث میشه تأیید خیریه موقتاً لغو بشه و مدیریت دوباره بررسی کنه.'],
            ['q' => 'اطلاعات تماس خیّر کجا نمایش داده میشه؟', 'a' => 'وقتی خیر به شما اهدا میکنه، نام، آدرس، تلفن و شماره همراه خیر توی داشبوردتون نمایش داده میشه تا برای هماهنگی تحویل استفاده کنین.'],
        ]; @endphp

        @foreach($charityFaqs as $faq)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <button onclick="toggleFaq(this)" class="w-full flex justify-between items-center p-5 text-right hover:bg-gray-50 transition">
                <span class="font-bold text-gray-800">{{ $faq['q'] }}</span>
                <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-gray-600 leading-relaxed">
                {!! $faq['a'] !!}
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function toggleFaq(btn) {
        const answer = btn.nextElementSibling;
        const icon = btn.querySelector('i');
        
        answer.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    function showTab(tab) {
        const donorBtn = document.getElementById('tab-donor');
        const charityBtn = document.getElementById('tab-charity');
        const donorFaq = document.getElementById('donor-faq');
        const charityFaq = document.getElementById('charity-faq');

        if (tab === 'donor') {
            donorBtn.className = 'px-6 py-3 rounded-lg font-bold transition bg-green-700 text-white';
            charityBtn.className = 'px-6 py-3 rounded-lg font-bold transition bg-gray-300 text-gray-700';
            donorFaq.classList.remove('hidden');
            charityFaq.classList.add('hidden');
        } else {
            charityBtn.className = 'px-6 py-3 rounded-lg font-bold transition bg-green-700 text-white';
            donorBtn.className = 'px-6 py-3 rounded-lg font-bold transition bg-gray-300 text-gray-700';
            charityFaq.classList.remove('hidden');
            donorFaq.classList.add('hidden');
        }
    }
</script>

<style>
    .rotate-180 {
        transform: rotate(180deg);
    }
    .fa-chevron-down {
        transition: transform 0.3s ease;
    }
</style>
@endsection