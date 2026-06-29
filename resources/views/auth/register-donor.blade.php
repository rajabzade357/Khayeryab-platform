<x-guest-layout>
   

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- هدر کارت -->
        <div class="bg-green-700 px-6 py-4 text-center">
            <h2 class="text-2xl font-bold text-white">ثبت‌نام خیر</h2>
        </div>

        <!-- فرم -->
        <form method="POST" action="{{ route('register.donor') }}" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="role" value="donor">

            <!-- نام -->
            <div>
                <label class="block text-gray-700 font-bold mb-2">
                    نام و نام خانوادگی *
                </label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500" 
                       placeholder="رضا محمدی" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            
        

            <!-- رمز عبور -->
            <div>
                <label class="block text-gray-700 font-bold mb-2">
                    رمز عبور *
                </label>
                <input type="password" name="password" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500" 
                       placeholder="••••••••" required>
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- تکرار رمز -->
            <div>
                <label class="block text-gray-700 font-bold mb-2">
                    تکرار رمز عبور *
                </label>
                <input type="password" name="password_confirmation" 
                       class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-green-500" 
                       placeholder="••••••••" required>
            </div>

            <!-- شهر  -->
            <div>
                <label class="block text-gray-700 font-bold mb-2">شهر *</label>
                <div class="searchable-select">
                    <input type="hidden" name="city" id="city" value="{{ old('city', '') }}">
                    <div class="select-input" onclick="toggleDropdown()">
                        <span id="city-display">{{ old('city') ?: 'انتخاب ' }}</span>
                        <i class="fas fa-chevron-down float-left text-gray-400 mt-1"></i>
                    </div>
                   <div id="city-dropdown" class="dropdown hidden">
                            <input type="text" id="city-search" class="search-input" placeholder="جستجو ..." 
                            onkeyup="filterCities()" onclick="event.stopPropagation()">
                        <div id="city-options">
                            <div class="option" data-value="آبادان" onclick="selectCity('آبادان')">آبادان</div>
                            <div class="option" data-value="آباده" onclick="selectCity('آباده')">آباده</div>
                            <div class="option" data-value="آبیک" onclick="selectCity('آبیک')">آبیک</div>
                            <div class="option" data-value="آبدانان" onclick="selectCity('آبدانان')">آبدانان</div>
                            <div class="option" data-value="آذرشهر" onclick="selectCity('آذرشهر')">آذرشهر</div>
                            <div class="option" data-value="آستارا" onclick="selectCity('آستارا')">آستارا</div>
                            <div class="option" data-value="آشتیان" onclick="selectCity('آشتیان')">آشتیان</div>
                            <div class="option" data-value="آق‌قلا" onclick="selectCity('آق‌قلا')">آق‌قلا</div>
                            <div class="option" data-value="آمل" onclick="selectCity('آمل')">آمل</div>
                            <div class="option" data-value="ابهر" onclick="selectCity('ابهر')">ابهر</div>
                            <div class="option" data-value="اردبیل" onclick="selectCity('اردبیل')">اردبیل</div>
                            <div class="option" data-value="اردکان" onclick="selectCity('اردکان')">اردکان</div>
                            <div class="option" data-value="اراک" onclick="selectCity('اراک')">اراک</div>
                            <div class="option" data-value="ارومیه" onclick="selectCity('ارومیه')">ارومیه</div>
                            <div class="option" data-value="اسلام‌آباد غرب" onclick="selectCity('اسلام‌آباد غرب')">اسلام‌آباد غرب</div>
                            <div class="option" data-value="اسلامشهر" onclick="selectCity('اسلامشهر')">اسلامشهر</div>
                            <div class="option" data-value="اشتهارد" onclick="selectCity('اشتهارد')">اشتهارد</div>
                            <div class="option" data-value="اصفهان" onclick="selectCity('اصفهان')">اصفهان</div>
                            <div class="option" data-value="الوند" onclick="selectCity('الوند')">الوند</div>
                            <div class="option" data-value="اهواز" onclick="selectCity('اهواز')">اهواز</div>
                            <div class="option" data-value="ایلام" onclick="selectCity('ایلام')">ایلام</div>
                            <div class="option" data-value="ایرانشهر" onclick="selectCity('ایرانشهر')">ایرانشهر</div>
                            <div class="option" data-value="بابل" onclick="selectCity('بابل')">بابل</div>
                            <div class="option" data-value="بافق" onclick="selectCity('بافق')">بافق</div>
                            <div class="option" data-value="بانه" onclick="selectCity('بانه')">بانه</div>
                            <div class="option" data-value="بندر ترکمن" onclick="selectCity('بندر ترکمن')">بندر ترکمن</div>
                            <div class="option" data-value="بندر لنگه" onclick="selectCity('بندر لنگه')">بندر لنگه</div>
                            <div class="option" data-value="بندرعباس" onclick="selectCity('بندرعباس')">بندرعباس</div>
                            <div class="option" data-value="بیرجند" onclick="selectCity('بیرجند')">بیرجند</div>
                            <div class="option" data-value="برازجان" onclick="selectCity('برازجان')">برازجان</div>
                            <div class="option" data-value="بروجن" onclick="selectCity('بروجن')">بروجن</div>
                            <div class="option" data-value="بروجرد" onclick="selectCity('بروجرد')">بروجرد</div>
                            <div class="option" data-value="بوئین‌زهرا" onclick="selectCity('بوئین‌زهرا')">بوئین‌زهرا</div>
                            <div class="option" data-value="بوکان" onclick="selectCity('بوکان')">بوکان</div>
                            <div class="option" data-value="بم" onclick="selectCity('بم')">بم</div>
                            <div class="option" data-value="بجنورد" onclick="selectCity('بجنورد')">بجنورد</div>
                            <div class="option" data-value="بوشهر" onclick="selectCity('بوشهر')">بوشهر</div>
                            <div class="option" data-value="پارس‌آباد" onclick="selectCity('پارس‌آباد')">پارس‌آباد</div>
                            <div class="option" data-value="پاوه" onclick="selectCity('پاوه')">پاوه</div>
                            <div class="option" data-value="تفت" onclick="selectCity('تفت')">تفت</div>
                            <div class="option" data-value="تهران" onclick="selectCity('تهران')">تهران</div>
                            <div class="option" data-value="تربت حیدریه" onclick="selectCity('تربت حیدریه')">تربت حیدریه</div>
                            <div class="option" data-value="تویسرکان" onclick="selectCity('تویسرکان')">تویسرکان</div>
                            <div class="option" data-value="تبریز" onclick="selectCity('تبریز')">تبریز</div>
                            <div class="option" data-value="جاسک" onclick="selectCity('جاسک')">جاسک</div>
                            <div class="option" data-value="جاجرم" onclick="selectCity('جاجرم')">جاجرم</div>
                            <div class="option" data-value="جعفریه" onclick="selectCity('جعفریه')">جعفریه</div>
                            <div class="option" data-value="جهرم" onclick="selectCity('جهرم')">جهرم</div>
                            <div class="option" data-value="جوانرود" onclick="selectCity('جوانرود')">جوانرود</div>
                            <div class="option" data-value="جیرفت" onclick="selectCity('جیرفت')">جیرفت</div>
                            <div class="option" data-value="چابهار" onclick="selectCity('چابهار')">چابهار</div>
                            <div class="option" data-value="خرم‌آباد" onclick="selectCity('خرم‌آباد')">خرم‌آباد</div>
                            <div class="option" data-value="خرمشهر" onclick="selectCity('خرمشهر')">خرمشهر</div>
                            <div class="option" data-value="خرمدره" onclick="selectCity('خرمدره')">خرمدره</div>
                            <div class="option" data-value="خمین" onclick="selectCity('خمین')">خمین</div>
                            <div class="option" data-value="خمینی‌شهر" onclick="selectCity('خمینی‌شهر')">خمینی‌شهر</div>
                            <div class="option" data-value="خوی" onclick="selectCity('خوی')">خوی</div>
                            <div class="option" data-value="دامغان" onclick="selectCity('دامغان')">دامغان</div>
                            <div class="option" data-value="دهدشت" onclick="selectCity('دهدشت')">دهدشت</div>
                            <div class="option" data-value="دهلران" onclick="selectCity('دهلران')">دهلران</div>
                            <div class="option" data-value="دزفول" onclick="selectCity('دزفول')">دزفول</div>
                            <div class="option" data-value="دلیجان" onclick="selectCity('دلیجان')">دلیجان</div>
                            <div class="option" data-value="دیر" onclick="selectCity('دیر')">دیر</div>
                            <div class="option" data-value="دره‌شهر" onclick="selectCity('دره‌شهر')">دره‌شهر</div>
                            <div class="option" data-value="دورود" onclick="selectCity('دورود')">دورود</div>
                            <div class="option" data-value="رشت" onclick="selectCity('رشت')">رشت</div>
                            <div class="option" data-value="رفسنجان" onclick="selectCity('رفسنجان')">رفسنجان</div>
                            <div class="option" data-value="رودسر" onclick="selectCity('رودسر')">رودسر</div>
                            <div class="option" data-value="ری" onclick="selectCity('ری')">ری</div>
                            <div class="option" data-value="زابل" onclick="selectCity('زابل')">زابل</div>
                            <div class="option" data-value="زاهدان" onclick="selectCity('زاهدان')">زاهدان</div>
                            <div class="option" data-value="زنجان" onclick="selectCity('زنجان')">زنجان</div>
                            <div class="option" data-value="ساری" onclick="selectCity('ساری')">ساری</div>
                            <div class="option" data-value="ساوجبلاغ" onclick="selectCity('ساوجبلاغ')">ساوجبلاغ</div>
                            <div class="option" data-value="ساوه" onclick="selectCity('ساوه')">ساوه</div>
                            <div class="option" data-value="سبزوار" onclick="selectCity('سبزوار')">سبزوار</div>
                            <div class="option" data-value="سراوان" onclick="selectCity('سراوان')">سراوان</div>
                            <div class="option" data-value="سلفچگان" onclick="selectCity('سلفچگان')">سلفچگان</div>
                            <div class="option" data-value="سنندج" onclick="selectCity('سنندج')">سنندج</div>
                            <div class="option" data-value="سمنان" onclick="selectCity('سمنان')">سمنان</div>
                            <div class="option" data-value="سیرجان" onclick="selectCity('سیرجان')">سیرجان</div>
                            <div class="option" data-value="سی‌سخت" onclick="selectCity('سی‌سخت')">سی‌سخت</div>
                            <div class="option" data-value="شاهین‌شهر" onclick="selectCity('شاهین‌شهر')">شاهین‌شهر</div>
                            <div class="option" data-value="شاهرود" onclick="selectCity('شاهرود')">شاهرود</div>
                            <div class="option" data-value="شهریار" onclick="selectCity('شهریار')">شهریار</div>
                            <div class="option" data-value="شیراز" onclick="selectCity('شیراز')">شیراز</div>
                            <div class="option" data-value="شیروان" onclick="selectCity('شیروان')">شیروان</div>
                            <div class="option" data-value="شهرکرد" onclick="selectCity('شهرکرد')">شهرکرد</div>
                            <div class="option" data-value="طبس" onclick="selectCity('طبس')">طبس</div>
                            <div class="option" data-value="فارسان" onclick="selectCity('فارسان')">فارسان</div>
                            <div class="option" data-value="فاروج" onclick="selectCity('فاروج')">فاروج</div>
                            <div class="option" data-value="فردوس" onclick="selectCity('فردوس')">فردوس</div>
                            <div class="option" data-value="فردیس" onclick="selectCity('فردیس')">فردیس</div>
                            <div class="option" data-value="قائم‌شهر" onclick="selectCity('قائم‌شهر')">قائم‌شهر</div>
                            <div class="option" data-value="قائن" onclick="selectCity('قائن')">قائن</div>
                            <div class="option" data-value="قروه" onclick="selectCity('قروه')">قروه</div>
                            <div class="option" data-value="قزوین" onclick="selectCity('قزوین')">قزوین</div>
                            <div class="option" data-value="قشم" onclick="selectCity('قشم')">قشم</div>
                            <div class="option" data-value="قم" onclick="selectCity('قم')">قم</div>
                            <div class="option" data-value="قوچان" onclick="selectCity('قوچان')">قوچان</div>
                            <div class="option" data-value="قیدار" onclick="selectCity('قیدار')">قیدار</div>
                            <div class="option" data-value="کازرون" onclick="selectCity('کازرون')">کازرون</div>
                            <div class="option" data-value="کاشان" onclick="selectCity('کاشان')">کاشان</div>
                            <div class="option" data-value="کرج" onclick="selectCity('کرج')">کرج</div>
                            <div class="option" data-value="کرمان" onclick="selectCity('کرمان')">کرمان</div>
                            <div class="option" data-value="کرمانشاه" onclick="selectCity('کرمانشاه')">کرمانشاه</div>
                            <div class="option" data-value="کنگان" onclick="selectCity('کنگان')">کنگان</div>
                            <div class="option" data-value="کنگاور" onclick="selectCity('کنگاور')">کنگاور</div>
                            <div class="option" data-value="کبودرآهنگ" onclick="selectCity('کبودرآهنگ')">کبودرآهنگ</div>
                            <div class="option" data-value="کهک" onclick="selectCity('کهک')">کهک</div>
                            <div class="option" data-value="کوهدشت" onclick="selectCity('کوهدشت')">کوهدشت</div>
                            <div class="option" data-value="کوهرنگ" onclick="selectCity('کوهرنگ')">کوهرنگ</div>
                            <div class="option" data-value="گرگان" onclick="selectCity('گرگان')">گرگان</div>
                            <div class="option" data-value="گرمسار" onclick="selectCity('گرمسار')">گرمسار</div>
                            <div class="option" data-value="گرمی" onclick="selectCity('گرمی')">گرمی</div>
                            <div class="option" data-value="گناوه" onclick="selectCity('گناوه')">گناوه</div>
                            <div class="option" data-value="گنبد کاووس" onclick="selectCity('گنبد کاووس')">گنبد کاووس</div>
                            <div class="option" data-value="گچساران" onclick="selectCity('گچساران')">گچساران</div>
                            <div class="option" data-value="لار" onclick="selectCity('لار')">لار</div>
                            <div class="option" data-value="لاهیجان" onclick="selectCity('لاهیجان')">لاهیجان</div>
                            <div class="option" data-value="لردگان" onclick="selectCity('لردگان')">لردگان</div>
                            <div class="option" data-value="لنگرود" onclick="selectCity('لنگرود')">لنگرود</div>
                            <div class="option" data-value="لیکک" onclick="selectCity('لیکک')">لیکک</div>
                            <div class="option" data-value="ماهشهر" onclick="selectCity('ماهشهر')">ماهشهر</div>
                            <div class="option" data-value="ماهنشان" onclick="selectCity('ماهنشان')">ماهنشان</div>
                            <div class="option" data-value="مراغه" onclick="selectCity('مراغه')">مراغه</div>
                            <div class="option" data-value="مرند" onclick="selectCity('مرند')">مرند</div>
                            <div class="option" data-value="مرودشت" onclick="selectCity('مرودشت')">مرودشت</div>
                            <div class="option" data-value="مریوان" onclick="selectCity('مریوان')">مریوان</div>
                            <div class="option" data-value="مشگین‌شهر" onclick="selectCity('مشگین‌شهر')">مشگین‌شهر</div>
                            <div class="option" data-value="مشهد" onclick="selectCity('مشهد')">مشهد</div>
                            <div class="option" data-value="ملایر" onclick="selectCity('ملایر')">ملایر</div>
                            <div class="option" data-value="مهاباد" onclick="selectCity('مهاباد')">مهاباد</div>
                            <div class="option" data-value="مهران" onclick="selectCity('مهران')">مهران</div>
                            <div class="option" data-value="مهدی‌شهر" onclick="selectCity('مهدی‌شهر')">مهدی‌شهر</div>
                            <div class="option" data-value="میاندوآب" onclick="selectCity('میاندوآب')">میاندوآب</div>
                            <div class="option" data-value="میانه" onclick="selectCity('میانه')">میانه</div>
                            <div class="option" data-value="میبد" onclick="selectCity('میبد')">میبد</div>
                            <div class="option" data-value="میناب" onclick="selectCity('میناب')">میناب</div>
                            <div class="option" data-value="نجف‌آباد" onclick="selectCity('نجف‌آباد')">نجف‌آباد</div>
                            <div class="option" data-value="نظرآباد" onclick="selectCity('نظرآباد')">نظرآباد</div>
                            <div class="option" data-value="نهاوند" onclick="selectCity('نهاوند')">نهاوند</div>
                            <div class="option" data-value="نهبندان" onclick="selectCity('نهبندان')">نهبندان</div>
                            <div class="option" data-value="نیشابور" onclick="selectCity('نیشابور')">نیشابور</div>
                            <div class="option" data-value="نوشهر" onclick="selectCity('نوشهر')">نوشهر</div>
                            <div class="option" data-value="ورامین" onclick="selectCity('ورامین')">ورامین</div>
                            <div class="option" data-value="یاسوج" onclick="selectCity('یاسوج')">یاسوج</div>
                            <div class="option" data-value="یزد" onclick="selectCity('یزد')">یزد</div>
                        </div>
                        <div id="city-no-result" class="no-result hidden">شهری یافت نشد</div>
                    </div>
                </div>
                @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- آدرس -->
            <div>
                <label class="block text-gray-700 font-bold mb-2">
                    آدرس *
                </label>
                <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg p-3" 
                          placeholder="خیابان، کوچه، پلاک..." required></textarea>
                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- تلفن -->
            <div>
                <label class="block text-gray-700 font-bold mb-2">
                    شماره تماس *
                </label>
                <input type="tel" name="phone" value="{{ old('phone') }}" 
                       class="w-full border border-gray-300 rounded-lg p-3" 
                       placeholder="۰۲۱-۱۲۳۴۵۶۷۸" required>
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- قوانین -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="terms" id="terms" class="w-4 h-4 text-green-600 rounded" required>
                <label for="terms" class="text-sm text-gray-600">
                    <a href="#" class="text-green-600 hover:underline">قوانین و مقررات</a> را می‌پذیرم
                </label>
            </div>

            <!-- دکمه ثبت‌نام -->
            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition">
                ثبت‌نام خیر
            </button>
        </form>

        <!-- لینک ورود -->
        <div class="border-t border-gray-200 px-6 py-4 text-center bg-gray-50">
            <p class="text-gray-600">
                قبلاً ثبت‌نام کرده‌اید؟
                <a href="{{ route('login') }}" class="text-green-600 font-bold hover:underline">ورود به حساب</a>
            </p>
            <p class="text-gray-500 text-sm mt-2">
                <a href="{{ route('register.charity') }}" class="text-green-600 hover:underline">
                    ثبت‌نام خیریه
                </a>
            </p>
        </div>
    </div>
    <style>
        .searchable-select { 
            position: relative; 
            width: 100%; 
        }
        .select-input { 
            width: 100%; 
            padding: 0.75rem; 
            border: 1px solid #d1d5db; 
            border-radius: 0.5rem; 
            background: white; 
            cursor: pointer; 
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .select-input:focus { 
            outline: none; 
            border-color: #10b981; 
        }
            .dropdown { 
            position: absolute; 
            top: 100%; 
            inset-inline-end: 0;
            width: 100%;
            z-index: 50; 
            background: white; 
            border: 1px solid #d1d5db; 
            border-radius: 0.5rem; 
            margin-top: 0.25rem; 
            max-height: 200px; 
            overflow-y: auto; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        }
            .search-input { 
            width: 100%; 
            padding: 0.5rem 0.75rem; 
            border: none; 
            border-bottom: 1px solid #e5e7eb; 
            outline: none; 
            text-align: right; 
        }
        .option { 
            padding: 0.5rem 0.75rem; 
            cursor: pointer; 
            text-align: right; 
        }
        .option:hover { 
            background: #f0fdf4; 
        }
            .no-result { 
            padding: 0.75rem; 
            text-align: center; 
            color: #9ca3af; 
            font-size: 0.875rem; 
        }
    
   </style>

    
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('city-dropdown');
            const search = document.getElementById('city-search');
            dropdown.classList.toggle('hidden');
            if (!dropdown.classList.contains('hidden')) {
                search.focus();
                filterCities();
            }
        }

        function selectCity(city) {
            document.getElementById('city').value = city;
            document.getElementById('city-display').textContent = city;
            document.getElementById('city-dropdown').classList.add('hidden');
        }

        function filterCities() {
            const search = document.getElementById('city-search').value.toLowerCase();
            const options = document.querySelectorAll('#city-options .option');
            const noResult = document.getElementById('city-no-result');
            let found = false;

            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                if (text.includes(search)) {
                    option.classList.remove('hidden');
                    found = true;
                } else {
                    option.classList.add('hidden');
                }
            });

            noResult.classList.toggle('hidden', found);
        }

        document.addEventListener('click', function(e) {
            const select = document.querySelector('.searchable-select');
            if (!select.contains(e.target)) {
                document.getElementById('city-dropdown').classList.add('hidden');
            }
        });
    </script>
</x-guest-layout>