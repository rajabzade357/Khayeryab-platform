@extends('layouts.app')

@section('title', 'داشبورد خیر')

@push('styles')
<style>
    /* کارت‌های آماری */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    
    .stat-card.blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .stat-card.green::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card.red::before { background: linear-gradient(90deg, #ef4444, #f87171); }
    .stat-card.yellow::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
    .stat-card.gray::before { background: linear-gradient(90deg, #6b7280, #9ca3af); }
    
    /* بخش‌های اصلی */
    .content-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }
    
    .content-card:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }
    
    /* جدول */
    .donation-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .donation-table th {
        background: #f8fafc;
        color: #475569;
        font-weight: 600;
        padding: 0.75rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e2e8f0;
        text-align: center;
    }
    
    .donation-table td {
        padding: 0.75rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.8rem;
        text-align: center;
    }
    
    .donation-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .donation-table tbody tr:hover {
        background: #f8fafc;
    }
    
    /* وضعیت‌ها */
    .status-badge {
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .status-waiting_charity { background: #fef3c7; color: #92400e; }
    .status-waiting_donor { background: #ede9fe; color: #5b21b6; }
    .status-waiting_transport { background: #fff7ed; color: #9a3412; }
    .status-approved { background: #dcfce7; color: #166534; }
    .status-rejected { background: #fee2e2; color: #991b1b; }
    .status-delivered { background: #dbeafe; color: #1e40af; }
    
    /* فرم */
    .form-input {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #f8fafc;
        font-size: 0.8rem;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #10b981;
        background: white;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .form-select {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .form-select:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }
    
    /* فیلترها */
    .filter-input, .filter-select {
        padding: 0.4rem 0.8rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }
    
    /* آپلود فایل */
    .file-upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 0.8rem;
        color: #94a3b8;
    }
    
    .file-upload-area:hover {
        border-color: #10b981;
        background: #f0fdf4;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- هدر داشبورد -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">داشبورد خیر</h2>
        <p class="text-gray-500 text-sm mt-1">مدیریت اهداهای شما</p>
    </div>

    <!-- کارت‌های آماری -->
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
        <div class="stat-card blue">
            <p class="text-gray-500 text-xs mb-1">کل اهداها</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalDonations ?? 0 }}</p>
        </div>
        
        <div class="stat-card green">
            <p class="text-gray-500 text-xs mb-1">تأیید شده</p>
            <p class="text-2xl font-bold text-green-600">{{ $approvedCount ?? 0 }}</p>
        </div>
        
        <div class="stat-card red">
            <p class="text-gray-500 text-xs mb-1">رد شده</p>
            <p class="text-2xl font-bold text-red-600">{{ $rejectedCount ?? 0 }}</p>
        </div>
        
        <div class="stat-card yellow">
            <p class="text-gray-500 text-xs mb-1">در انتظار خودروی خیریه</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $waitingCharityCount ?? 0 }}</p>
        </div>
        
        <div class="stat-card purple">
            <p class="text-gray-500 text-xs mb-1">در انتظار تحویل</p>
            <p class="text-2xl font-bold text-purple-600">{{ $waitingDonorCount ?? 0 }}</p>
        </div>
        
        <div class="stat-card gray">
            <p class="text-gray-500 text-xs mb-1">امتیاز منفی</p>
            <p class="text-2xl font-bold text-gray-600">{{ $violationCount ?? 0 }}</p>
        </div>
    </div>

    <!-- لیست اهداها -->
    <div class="content-card">
        <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
            <h3 class="text-lg font-bold text-gray-700">لیست اهداها</h3>
            <div class="flex gap-3">
                <select id="statusFilter" class="filter-select">
                    <option value="all">همه وضعیت‌ها</option>
                    <option value="waiting_for_charity">در انتظار خیریه</option>
                    <option value="waiting_for_donor">در انتظار تحویل شما</option>
                    <option value="waiting_for_transport">در انتظار خودروی خیریه</option>
                    <option value="approved">تأیید شده</option>
                    <option value="rejected">رد شده</option>
                    <option value="delivered">تحویل شده</option>
                </select>
                <input type="text" id="searchDonation" placeholder="جستجوی عنوان..." class="filter-input w-48">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="donation-table">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>خیریه</th>
                        <th>دسته</th>
                        <th>روش تحویل</th>
                        <th>تاریخ تحویل</th>
                        <th>وضعیت</th>
                    </tr>
                </thead>
                <tbody id="donationsList">
                    @forelse($donations as $donation)
                        <tr class="donation-row"
                            data-title="{{ $donation->title }}"
                            data-status="{{ $donation->status }}">
                            <td class="font-medium">{{ $donation->title }}</td>
                            <td>{{ $donation->charity->user->name ?? '-' }}</td>
                            <td>
                                <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">
                                    {{ $donation->category == 'small' ? 'کوچک' : 'بزرگ' }}
                                </span>
                            </td>
                            <td>
                                <span class="text-xs">
                                    {{ $donation->delivery_method == 'charity_location' ? 'تحویل در خیریه' : 'گرفتن از منزل' }}
                                </span>
                            </td>
                            <td>
                                @if($donation->pickup_date)
                                    <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full">
                                        {{ \Carbon\Carbon::parse($donation->pickup_date)->format('Y/m/d') }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td>
                            @switch($donation->status)
                                @case('waiting_for_charity')
                                    <span class="status-badge status-waiting_charity">در انتظار خیریه</span>
                                    @break
                                @case('waiting_for_donor')
                                    <span class="status-badge status-waiting_donor">منتظر تحویل شما</span>
                                    @break
                                @case('waiting_for_vehicle')
                                    <span class="status-badge status-waiting_transport">منتظر خودروی خیریه</span>
                                    @break
                                @case('delivered')
                                    <span class="status-badge status-delivered">تحویل داده شد</span>
                                    @break
                                @case('vehicle_delivered')
                                    <span class="status-badge status-delivered">خودرو تحویل گرفت</span>
                                    @break
                                @case('rejected')
                                    <span class="status-badge status-rejected">رد شده</span>
                                    @break
                                @case('not_delivered')
                                    <span class="status-badge status-rejected">تحویل داده نشد</span>
                                    @break
                                @default
                                    <span class="text-gray-500 text-xs">نامشخص</span>
                            @endswitch
                            </td>
                        </tr>
                        @empty
                        <tr>
                           <td colspan="6" class="text-center py-8">
                             <p class="text-gray-400 text-sm">هنوز اهدایی ثبت نشده است</p>
                           </td>
                       </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- فرم ثبت اهدا -->
    <div class="content-card">
        <h3 class="text-lg font-bold text-gray-700 mb-6">ثبت اهدای جدید</h3>
        
        <form action="{{ route('donor.donation.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">عنوان وسیله *</label>
                    <input type="text" name="title" class="form-input" placeholder="مثال: مبل راحتی ۳ نفره" required>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">توضیحات</label>
                    <textarea name="description" rows="2" class="form-input" placeholder="توضیحات بیشتر درباره وسیله..."></textarea>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">دسته‌بندی *</label>
                    <select name="category" class="form-select" required>
                        <option value="small">کوچک (قابل حمل با خودرو)</option>
                        <option value="large">بزرگ (نیاز به وانت)</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">انتخاب خیریه *</label>
                    <select name="charity_id" class="form-select" required>
                        <option value="">یک خیریه انتخاب کنید...</option>
                        @foreach($charities as $charity)
                            <option value="{{ $charity->id }}">
                                {{ $charity->user->name }} - {{ $charity->user->city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">روش تحویل *</label>
                    <select name="delivery_method" class="form-select" required>
                        <option value="charity_location">تحویل در محل خیریه</option>
                        <option value="donor_location">تحویل به خوردو خیریه</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">تاریخ تحویل</label>
                    <input type="date" name="pickup_date" class="form-input">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-2">تصاویر وسیله</label>
                    <div class="file-upload-area">
                        <input type="file" name="images[]" multiple class="hidden" id="fileInput">
                        <label for="fileInput" class="cursor-pointer">
                            کلیک کنید یا تصاویر را اینجا بکشید
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="btn-submit">ثبت اهدا</button>
            </div>
        </form>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
    const filterSelect = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchDonation');
    const rows = document.querySelectorAll('.donation-row');

    function filterTable() {
        const status = filterSelect.value;
        const query = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            const rowTitle = row.getAttribute('data-title').toLowerCase();
            const statusMatch = status === 'all' || rowStatus === status;
            const titleMatch = query === '' || rowTitle.includes(query);
            row.style.display = statusMatch && titleMatch ? '' : 'none';
        });
    }

    filterSelect.addEventListener('change', filterTable);
    searchInput.addEventListener('keyup', filterTable);
</script>
@endpush