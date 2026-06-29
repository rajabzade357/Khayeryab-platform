<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


<!-- City -->
<div class="mt-4">
    <x-input-label for="city" :value="__('شهر')" />
    <select id="city" name="city" class="rounded-md border-gray-300 w-full mt-1" required>
        <option value="">انتخاب </option>
        <option value="abadan">آبادان</option>
        <option value="abhar">ابهر</option>
        <option value="ahvaz">اهواز</option>
        <option value="alamut">الوند</option>
        <option value="amol">آمل</option>
        <option value="arak">اراک</option>
        <option value="ardabil">اردبیل</option>
        <option value="ardakan">اردکان</option>
        <option value="urmia">ارومیه</option>
        <option value="isfahan">اصفهان</option>
        <option value="esfarayen">اسفراین</option>
        <option value="eslamabad">اسلام آباد غرب</option>
        <option value="eslamshahr">اسلام شهر</option>
        <option value="ilam">ایلام</option>
        <option value="ivan">ایوان</option>
        <option value="iran shahr">ایرانشهر</option>
        <option value="babol">بابل</option>
        <option value="bafq">بافق</option>
        <option value="bandar abbas">بندرعباس</option>
        <option value="bandar anzali">بندر انزلی</option>
        <option value="bandar genaveh">بندر گناوه</option>
        <option value="bandar lengeh">بندر لنگه</option>
        <option value="bandar torkaman">بندر ترکمن</option>
        <option value="baneh">بانه</option>
        <option value="birjand">بیرجند</option>
        <option value="bojnord">بجنورد</option>
        <option value="borazjan">برازجان</option>
        <option value="boroujerd">بروجرد</option>
        <option value="boroujen">بروجن</option>
        <option value="bushehr">بوشهر</option>
        <option value="chabahar">چابهار</option>
        <option value="damghan">دامغان</option>
        <option value="dehbarez">دهبارز</option>
        <option value="dehloran">دهلران</option>
        <option value="dehdasht">دهدشت</option>
        <option value="dezful">دزفول</option>
        <option value="dogombadan">دوگنبدان</option>
        <option value="doroud">دورود</option>
        <option value="farokh shahr">فرخ شهر</option>
        <option value="farsan">فارسان</option>
        <option value="ferdows">فردوس</option>
        <option value="garmeh">گرمه</option>
        <option value="garmsar">گرمسار</option>
        <option value="golestan">گلستان</option>
        <option value="gonbad kavous">گنبد کاووس</option>
        <option value="gorgan">گرگان</option>
        <option value="hamadan">همدان</option>
        <option value="harsin">هرسین</option>
        <option value="hashtgerd">هشتگرد</option>
        <option value="ilam">ایلام</option>
        <option value="jajarm">جاجرم</option>
        <option value="jahrom">جهرم</option>
        <option value="jirouft">جیرفت</option>
        <option value="kashan">کاشان</option>
        <option value="kazeroun">کازرون</option>
        <option value="kerman">کرمان</option>
        <option value="kermanshah">کرمانشاه</option>
        <option value="khalkhal">خلخال</option>
        <option value="khomeini shahr">خمینی شهر</option>
        <option value="khomein">خمین</option>
        <option value="khorramabad">خرم‌آباد</option>
        <option value="khorramdarreh">خرمدره</option>
        <option value="khorramshahr">خرمشهر</option>
        <option value="khormoj">خورموج</option>
        <option value="khoy">خوی</option>
        <option value="koohdasht">کوهدشت</option>
        <option value="kordkuy">کردکوی</option>
        <option value="lahijan">لاهیجان</option>
        <option value="lar">لار</option>
        <option value="langaroud">لنگرود</option>
        <option value="likak">لیکک</option>
        <option value="mahabad">مهاباد</option>
        <option value="mahalat">محلات</option>
        <option value="malayer">ملایر</option>
        <option value="maragheh">مراغه</option>
        <option value="marand">مرند</option>
        <option value="marivan">مریوان</option>
        <option value="marvdasht">مرودشت</option>
        <option value="mashhad">مشهد</option>
        <option value="masjed soleyman">مسجد سلیمان</option>
        <option value="meshgin shahr">مشگین شهر</option>
        <option value="miandoab">میاندوآب</option>
        <option value="mianeh">میانه</option>
        <option value="meybod">میبد</option>
        <option value="minab">میناب</option>
        <option value="mohammad shahr">محمدشهر</option>
        <option value="najafabad">نجف آباد</option>
        <option value="nazarabad">نظرآباد</option>
        <option value="nehbandan">نهبندان</option>
        <option value="nishabur">نیشابور</option>
        <option value="nahanad">نهاوند</option>
        <option value="parsabad">پارس آباد</option>
        <option value="qeshm">قشم</option>
        <option value="qom">قم</option>
        <option value="qorveh">قروه</option>
        <option value="qazvin">قزوین</option>
        <option value="qayen">قائن</option>
        <option value="qeydar">قیدار</option>
        <option value="qods">قدس</option>
        <option value="rasht">رشت</option>
        <option value="rafsanjan">رفسنجان</option>
        <option value="sabzevar">سبزوار</option>
        <option value="sanandaj">سنندج</option>
        <option value="sari">ساری</option>
        <option value="saveh">ساوه</option>
        <option value="semnan">سمنان</option>
        <option value="saqqez">سقز</option>
        <option value="shahrekord">شهرکرد</option>
        <option value="shahroud">شاهرود</option>
        <option value="shiraz">شیراز</option>
        <option value="shirvan">شیروان</option>
        <option value="tabas">طبس</option>
        <option value="tabriz">تبریز</option>
        <option value="takes tan">تاکستان</option>
        <option value="tehran">تهران</option>
        <option value="torbat heydariyeh">تربت حیدریه</option>
        <option value="touyserkan">تویسرکان</option>
        <option value="varamin">ورامین</option>
        <option value="yasuj">یاسوج</option>
        <option value="yazd">یزد</option>
        <option value="zabol">زابل</option>
        <option value="zahedan">زاهدان</option>
        <option value="zanjan">زنجان</option>
            </select>
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

<!-- Address -->
<div class="mt-4">
    <x-input-label for="address" :value="__('آدرس (اختیاری)')" />
    <textarea id="address" name="address" class="rounded-md border-gray-300 w-full mt-1" rows="2"></textarea>
    <x-input-error :messages="$errors->get('address')" class="mt-2" />
</div>

<!-- Phone -->
<div class="mt-4">
    <x-input-label for="phone" :value="__('تلفن (اختیاری)')" />
    <input type="text" id="phone" name="phone" class="rounded-md border-gray-300 w-full mt-1" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
</div>
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
