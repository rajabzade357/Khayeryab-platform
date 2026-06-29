<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-6">
        <div id="alert-area"></div>

        <div>
            <p class="text-gray-700 text-center font-bold text-lg mb-4">تغییر شماره موبایل</p>
            <p class="text-gray-500 text-center text-sm mb-4">
                شماره فعلی: <span class="font-bold">{{ Auth::user()->mobile ?? 'ثبت نشده' }}</span>
            </p>
            
            <label class="block text-gray-500 mb-2">شماره موبایل جدید (۱۱ رقم) *</label>
            <input type="tel" id="phone" name="phone" 
                   class="w-full border border-gray-300 rounded-lg p-3" 
                   placeholder="09123456789" required>
        </div>

        <button type="button" id="verify-btn" 
                class="w-full bg-green-600 text-white py-3 rounded-lg mt-4">
            ذخیره شماره جدید
        </button>
    </div>

    <script>
        const verifyBtn = document.getElementById('verify-btn');
        const alertArea = document.getElementById('alert-area');

        verifyBtn.addEventListener('click', function() {
            const phone = document.getElementById('phone').value;

            if (!phone || phone.length !== 11) {
                alertArea.innerHTML = '<div class="bg-red-100 text-red-700 p-3 rounded mb-4">شماره موبایل باید ۱۱ رقم باشد</div>';
                return;
            }

            verifyBtn.disabled = true;
            verifyBtn.textContent = 'در حال ذخیره...';

            fetch('{{ route("verify.phone.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ phone: phone })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alertArea.innerHTML = '<div class="bg-green-100 text-green-700 p-3 rounded mb-4"> شماره با موفقیت تغییر کرد</div>';
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 800);
                } else {
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'ذخیره شماره جدید';
                    alertArea.innerHTML = '<div class="bg-red-100 text-red-700 p-3 rounded mb-4"> ' + (data.error || 'خطا') + '</div>';
                }
            })
            .catch(() => {
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'ذخیره شماره جدید';
                alertArea.innerHTML = '<div class="bg-red-100 text-red-700 p-3 rounded mb-4"> خطا در ارتباط با سرور</div>';
            });
        });
    </script>
</x-guest-layout>