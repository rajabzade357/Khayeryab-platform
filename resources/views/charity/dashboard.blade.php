@extends('layouts.app')

@section('title', 'داشبورد خیریه')

@section('content')

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- کارت‌های آماری -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-3 text-center border-r-4 border-blue-500">
                <p class="text-gray-500 text-xs">کل</p>
                <p class="text-xl font-bold" id="totalCount">0</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-3 text-center border-r-4 border-green-500">
                <p class="text-gray-500 text-xs">تحویل داده</p>
                <p class="text-xl font-bold text-green-600" id="deliveredCount">0</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-3 text-center border-r-4 border-teal-500">
                <p class="text-gray-500 text-xs">خودرو تحویل</p>
                <p class="text-xl font-bold text-teal-600" id="vehicleDeliveredCount">0</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-3 text-center border-r-4 border-red-500">
                <p class="text-gray-500 text-xs">رد شده</p>
                <p class="text-xl font-bold text-red-600" id="rejectedCount">0</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-3 text-center border-r-4 border-yellow-500">
                <p class="text-gray-500 text-xs">در انتظار بررسی</p>
                <p class="text-xl font-bold text-yellow-600" id="pendingCount">0</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-3 text-center border-r-4 border-purple-500">
                <p class="text-gray-500 text-xs">منتظر خیر</p>
                <p class="text-xl font-bold text-purple-600" id="waitingDonorCount">0</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-3 text-center border-r-4 border-orange-500">
                <p class="text-gray-500 text-xs">منتظر خودرو</p>
                <p class="text-xl font-bold text-orange-600" id="waitingVehicleCount">0</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-3 text-center border-r-4 border-gray-500">
                <p class="text-gray-500 text-xs">تحویل نشده</p>
                <p class="text-xl font-bold text-gray-600" id="notDeliveredCount">0</p>
            </div>
        </div>

        <!-- جدول مدیریت اهداها -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center flex-wrap gap-3">
                <h2 class="text-xl font-bold text-gray-800"> مدیریت اهداها</h2>
                <div class="flex gap-2">
                    <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="all">همه</option>
                        <option value="waiting_for_charity">در انتظار بررسی</option>
                        <option value="waiting_for_donor">منتظر خیر</option>
                        <option value="waiting_for_vehicle">منتظر خودرو</option>
                        <option value="delivered">تحویل داده</option>
                        <option value="vehicle_delivered">خودرو تحویل گرفته</option>
                        <option value="rejected">رد شده</option>
                        <option value="not_delivered">تحویل نشده</option>
                    </select>
                    <input type="text" id="searchInput" placeholder="جستجو..." class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-48">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr class="text-right text-gray-600">
                            <th class="px-4 py-3">وسیله</th>
                            <th class="px-4 py-3">توضیحات</th>
                            <th class="px-4 py-3">خیر</th>
                            <th class="px-4 py-3">آدرس</th>
                            <th class="px-4 py-3">تلفن منزل</th>
                            <th class="px-4 py-3">شماره همراه</th>
                            <th class="px-4 py-3">دسته</th>
                            <th class="px-4 py-3">روش تحویل</th>
                            <th class="px-4 py-3">تاریخ تحویل</th>
                            <th class="px-4 py-3">وضعیت</th>
                            <th class="px-4 py-3">عملیات</th>
                        </tr>
                    </thead>
                    <tbody id="donationsTable">
                        <tr><td colspan="7" class="text-center py-8 text-gray-500">در حال بارگذاری...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- وسایل ترجیحی -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800"> وسایل ترجیحی</h2>
                <button onclick="showAddPreferredModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                    <i class="fas fa-plus ml-1"></i> افزودن
                </button>
            </div>
            <div class="p-6">
                <div id="preferredItemsList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="text-center text-gray-500 py-8">بارگذاری...</div>
                </div>
            </div>
        </div>
    </div>


    <!-- مودال تأیید/رد -->
    <div id="actionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4" id="modalTitle"></h3>
            <p class="text-gray-600 mb-4" id="modalMessage"></p>
            <div id="rejectReasonDiv" class="hidden mb-4">
                <label class="block text-gray-700 font-bold mb-2">دلیل:</label>
                <select id="rejectReason" class="w-full border border-gray-300 rounded-lg p-2">
                    <option value="not_present">پاسخگو نبود / تحویل نداد</option>
                    <option value="inappropriate">جنس نامناسب</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button id="confirmAction" class="flex-1 text-white py-2 rounded-lg"></button>
                <button onclick="closeModal()" class="flex-1 border py-2 rounded-lg hover:bg-gray-50">انصراف</button>
            </div>
        </div>
    </div>

    <!-- مودال افزودن وسیله -->
    <div id="addPreferredModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">افزودن وسیله ترجیحی</h3>
            <div class="space-y-4">
                <div><label class="block text-gray-700 font-bold mb-2">عنوان *</label><input type="text" id="preferredTitle" class="w-full border border-gray-300 rounded-lg p-2"></div>
                <div><label class="block text-gray-700 font-bold mb-2">توضیحات</label><textarea id="preferredDesc" rows="2" class="w-full border border-gray-300 rounded-lg p-2"></textarea></div>
                <div><label class="block text-gray-700 font-bold mb-2">اولویت</label>
                    <select id="preferredPriority" class="w-full border border-gray-300 rounded-lg p-2">
                        <option value="high">اولویت بالا</option>
                        <option value="medium">متوسط</option>
                        <option value="normal">عادی</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button onclick="savePreferredItem()" class="flex-1 bg-green-600 text-white py-2 rounded-lg">ذخیره</button>
                <button onclick="closeAddPreferredModal()" class="flex-1 border py-2 rounded-lg">انصراف</button>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    let allDonations = [];
    let currentDonationId = null;
    let currentAction = null;
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    function loadDashboard() {
        fetch('/charity/dashboard-data')
            .then(res => res.json())
            .then(data => {
                document.getElementById('totalCount').innerText = data.stats.total;
                document.getElementById('deliveredCount').innerText = data.stats.delivered;
                document.getElementById('vehicleDeliveredCount').innerText = data.stats.vehicle_delivered;
                document.getElementById('rejectedCount').innerText = data.stats.rejected;
                document.getElementById('pendingCount').innerText = data.stats.waiting_for_charity;
                document.getElementById('waitingDonorCount').innerText = data.stats.waiting_for_donor;
                document.getElementById('waitingVehicleCount').innerText = data.stats.waiting_for_vehicle;
                document.getElementById('notDeliveredCount').innerText = data.stats.not_delivered;
                allDonations = data.donations;
                renderDonationsTable();
                renderPreferredItems(data.preferredItems);
            });
    }

    function getStatusBadge(status) {
        const badges = {
            'waiting_for_charity': '<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">در انتظار بررسی</span>',
            'waiting_for_donor': '<span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">منتظر خیر</span>',
            'waiting_for_vehicle': '<span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-xs">منتظر خودرو</span>',
            'delivered': '<span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">تحویل داده</span>',
            'vehicle_delivered': '<span class="bg-teal-100 text-teal-700 px-2 py-1 rounded-full text-xs">خودرو تحویل گرفت</span>',
            'rejected': '<span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">رد شده</span>',
            'not_delivered': '<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">تحویل نشده</span>',
        };
        return badges[status] || status;
    }

    function getActionButtons(d) {
        let buttons = '';
        
        if (d.status === 'waiting_for_charity') {
            buttons += `<button onclick="doAction(${d.id}, 'approve')" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600 ml-1"> تأیید</button>`;
            buttons += `<button onclick="doAction(${d.id}, 'reject')" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 ml-1"> رد</button>`;
        }
        
        else if (d.status === 'waiting_for_donor') {
            buttons += `<button onclick="doAction(${d.id}, 'delivered')" class="bg-green-500 text-white px-2 py-1 rounded text-xs hover:bg-green-600 ml-1"> تحویل داده شد</button>`;
            buttons += `<button onclick="doAction(${d.id}, 'not_delivered')" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 ml-1"> تحویل داده نشد</button>`;
            buttons += `<button onclick="doAction(${d.id}, 'undo_approval')" class="bg-gray-400 text-white px-2 py-1 rounded text-xs hover:bg-gray-500 ml-1"> لغو</button>`;
        }
        
        else if (d.status === 'waiting_for_vehicle') {
            buttons += `<button onclick="doAction(${d.id}, 'vehicle_delivered')" class="bg-teal-500 text-white px-2 py-1 rounded text-xs hover:bg-teal-600 ml-1"> توسط خودرو تحویل گرفته شد</button>`;
            buttons += `<button onclick="doAction(${d.id}, 'not_delivered')" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 ml-1"> تحویل داده نشد</button>`;
            buttons += `<button onclick="doAction(${d.id}, 'undo_approval')" class="bg-gray-400 text-white px-2 py-1 rounded text-xs hover:bg-gray-500 ml-1"> لغو</button>`;
        }
        
        else if (d.status === 'rejected') {
            buttons += `<button onclick="doAction(${d.id}, 'undo_reject')" class="bg-gray-400 text-white px-2 py-1 rounded text-xs hover:bg-gray-500 ml-1">↩ لغو رد</button>`;
        }

        return buttons || '<span class="text-gray-400 text-xs">—</span>';
    }

    function renderDonationsTable() {
        const tbody = document.getElementById('donationsTable');
        const filter = document.getElementById('statusFilter').value;
        const search = document.getElementById('searchInput').value.toLowerCase();
        
        let filtered = allDonations;
        if (filter !== 'all') filtered = allDonations.filter(d => d.status === filter);
        if (search) filtered = filtered.filter(d => d.title?.toLowerCase().includes(search) || d.donor_name?.toLowerCase().includes(search));
        
        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-8 text-gray-500"> اهدایی یافت نشد</td></tr>';
            return;
        }
        
        tbody.innerHTML = filtered.map(d => `
            <tr class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">${d.title || '-'}</td>
                <td class="px-4 py-3">${d.description || '-'}</td>
                <td class="px-4 py-3">${d.donor_name || '-'}</td>
                <td class="px-4 py-3">${d.address || '-'}</td>
                <td class="px-4 py-3">${d.phone || '-'}</td>
                <td class="px-4 py-3">${d.mobile || '-'}</td>
                <td class="px-4 py-3">${d.category === 'small' ? 'کوچک' : 'بزرگ'}</td>
                <td class="px-4 py-3">${d.delivery_method === 'charity_location' ? 'خودرو خیریه' : 'تحویل توسط خیر'}</td>
                <td class="px-4 py-3">${d.pickup_date || '-'}</td>
                <td class="px-4 py-3">${getStatusBadge(d.status)}</td>
                <td class="px-4 py-3">${getActionButtons(d)}</td>
            </tr>
        `).join('');
    }

    function doAction(id, action) {
        currentDonationId = id;
        currentAction = action;

        if (action === 'not_delivered') {
            document.getElementById('modalTitle').innerText = 'تحویل داده نشد';
            document.getElementById('modalMessage').innerText = 'لطفاً دلیل را انتخاب کنید:';
            document.getElementById('rejectReasonDiv').classList.remove('hidden');
            document.getElementById('confirmAction').className = 'flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg';
            document.getElementById('confirmAction').innerText = 'ثبت';
            document.getElementById('actionModal').classList.remove('hidden');
        } else {
            document.getElementById('rejectReasonDiv').classList.add('hidden');
            document.getElementById('modalTitle').innerText = getActionTitle(action);
            document.getElementById('modalMessage').innerText = 'آیا اطمینان دارید؟';
            document.getElementById('confirmAction').className = 'flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg';
            document.getElementById('confirmAction').innerText = 'تأیید';
            document.getElementById('actionModal').classList.remove('hidden');
        }
    }

    function getActionTitle(action) {
        const titles = {
            'approve': 'تأیید اهدا',
            'reject': 'رد اهدا',
            'delivered': 'تحویل داده شد',
            'vehicle_delivered': 'توسط خودرو تحویل گرفته شد',
            'undo_approval': 'لغو تأیید',
            'undo_reject': 'لغو رد',
            'not_delivered': 'تحویل داده نشد',
        };
        return titles[action] || '';
    }

    function getActionUrl(action) {
        const urls = {
            'approve': `/charity/donation/${currentDonationId}/approve`,
            'reject': `/charity/donation/${currentDonationId}/reject`,
            'delivered': `/charity/donation/${currentDonationId}/delivered`,
            'vehicle_delivered': `/charity/donation/${currentDonationId}/vehicle-delivered`,
            'not_delivered': `/charity/donation/${currentDonationId}/not-delivered`,
            'undo_approval': `/charity/donation/${currentDonationId}/undo-approval`,
            'undo_reject': `/charity/donation/${currentDonationId}/undo-reject`,
        };
        return urls[action];
    }

    document.getElementById('confirmAction').addEventListener('click', function() {
        if (!currentDonationId || !currentAction) return;
        
        const body = {};
        if (currentAction === 'reject' || currentAction === 'not_delivered') {
            body.reason = document.getElementById('rejectReason').value;
        }
        
        fetch(getActionUrl(currentAction), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeModal();
                loadDashboard();
            } else {
                alert(data.message || 'خطا');
            }
        });
    });

    function closeModal() {
        document.getElementById('actionModal').classList.add('hidden');
        currentDonationId = null;
        currentAction = null;
    }

    function renderPreferredItems(items) {
        const container = document.getElementById('preferredItemsList');
        if (!items || items.length === 0) {
            container.innerHTML = '<div class="text-center text-gray-500 py-8 col-span-2">هیچ وسیله‌ای ثبت نشده</div>';
            return;
        }
        container.innerHTML = items.map(item => `
            <div class="border rounded-lg p-4 flex justify-between items-start">
                <div>
                    <h3 class="font-bold">${item.title}</h3>
                    <p class="text-sm text-gray-600">${item.description || ''}</p>
                    <span class="text-xs ${item.priority === 'high' ? 'text-red-500' : item.priority === 'medium' ? 'text-yellow-500' : 'text-gray-500'}">${item.priority === 'high' ? 'بالا' : item.priority === 'medium' ? 'متوسط' : 'عادی'}</span>
                </div>
                <button onclick="deletePreferredItem(${item.id})" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
            </div>
        `).join('');
    }

    function showAddPreferredModal() { document.getElementById('addPreferredModal').classList.remove('hidden'); }
    function closeAddPreferredModal() { document.getElementById('addPreferredModal').classList.add('hidden'); }

    function savePreferredItem() {
        const title = document.getElementById('preferredTitle').value;
        if (!title) { alert('عنوان الزامی است'); return; }
        
        fetch('/charity/preferred-items', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify({
                title: title,
                description: document.getElementById('preferredDesc').value,
                priority: document.getElementById('preferredPriority').value
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) { closeAddPreferredModal(); loadDashboard(); }
        });
    }

    function deletePreferredItem(id) {
        if (!confirm('حذف شود؟')) return;
        fetch(`/charity/preferred-items/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => { if (data.success) loadDashboard(); });
    }

    document.getElementById('statusFilter').addEventListener('change', renderDonationsTable);
    document.getElementById('searchInput').addEventListener('keyup', renderDonationsTable);

    loadDashboard();
</script>
@endpush