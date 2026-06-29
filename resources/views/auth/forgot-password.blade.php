<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-6">
        <div id="alert-area"></div>

        <div>
            <p class="text-gray-700 text-center font-bold text-lg mb-4">بازیابی رمز عبور</p>
            <p class="text-gray-500 text-center text-sm mb-4">شماره موبایل تأیید شده خود را وارد کنید</p>
            
            <label class="block text-gray-500 mb-2">شماره موبایل (۱۱ رقم) *</label>
            <input type="tel" id="phone" name="phone" 
                   class="w-full border border-gray-300 rounded-lg p-3" 
                   placeholder="09123456789" required>
        </div>

        <button type="button" id="verify-btn" 
                class="w-full bg-green-600 text-white py-3 rounded-lg mt-4">
            تأیید و ادامه
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-green-600 text-sm hover:underline">
                بازگشت به ورود
            </a>
        </div>
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
            verifyBtn.textContent = 'در حال بررسی...';

            fetch('{{ route("password.verify") }}', {
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
                    alertArea.innerHTML = '<div class="bg-green-100 text-green-700 p-3 rounded mb-4"> در حال انتقال...</div>';
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 500);
                } else {
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'تأیید و ادامه';
                    alertArea.innerHTML = '<div class="bg-red-100 text-red-700 p-3 rounded mb-4"> ' + (data.error || 'خطا') + '</div>';
                }
            })
            .catch(() => {
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'تأیید و ادامه';
                alertArea.innerHTML = '<div class="bg-red-100 text-red-700 p-3 rounded mb-4">❌ خطا در ارتباط با سرور</div>';
            });
        });
    </script>
</x-guest-layout>