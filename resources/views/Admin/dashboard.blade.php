@extends('admin.layouts.admin')

@section('title', 'داشبورد')

@section('content')
{{-- ردیف اول: ۴ کارت آماری  --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">کل کاربران</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</h3>
            </div>
           
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">خیریه‌ها</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stats['total_charities'] }}</h3>
            </div>
            
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">کمک‌های فعال</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stats['active_donations'] }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">در انتظار تأیید</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $stats['pending_charities'] }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- ردیف دوم: ۴ کارت گزارشات --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-red-500">
        <p class="text-gray-500 text-sm">کل خیرها</p>
        <h3 class="text-3xl font-bold">{{ $reportStats['total_donors'] }}</h3>
        <p class="text-xs text-gray-400 mt-1">فعال: {{ $reportStats['active_donors'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-purple-500">
        <p class="text-gray-500 text-sm">خیریه‌های تأیید شده</p>
        <h3 class="text-3xl font-bold">{{ $reportStats['approved_charities'] }}</h3>
        <p class="text-xs text-gray-400 mt-1">در انتظار: {{ $reportStats['pending_charities'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-red-500">
        <p class="text-gray-500 text-sm">کل کمک‌ها</p>
        <h3 class="text-3xl font-bold">{{ $reportStats['total_donations'] }}</h3>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-r-4 border-purple-500">
        <p class="text-gray-500 text-sm">تحویل داده شده</p>
        <h3 class="text-3xl font-bold">{{ $reportStats['completed_donations'] }}</h3>
    </div>
</div>

{{-- ردیف سوم: نمودار + کاربران اخیر --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- نمودار سمت راست --}}
    <div class="bg-white rounded-xl shadow-sm p-6 order-2 lg:order-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4">کاربران اخیر</h3>
        <div class="space-y-3">
            @foreach($stats['recent_users'] as $user)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-bold">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->role === 'charity' ? 'خیریه' : 'خیر' }}</p>
                    </div>
                </div>
                <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{--  چپ --}}
    <div class="bg-white rounded-xl shadow-sm p-6 order-1 lg:order-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4">کمک‌های ماهانه</h3>
        <canvas id="monthlyChart" height="200"></canvas>
    </div>
</div>

{{-- ردیف چهارم: وضعیت کمک‌ها --}}
<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">وضعیت کمک‌ها</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($reportStats['donations_by_status'] as $item)
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-2xl font-bold">{{ $item->count }}</p>
            <p class="text-sm text-gray-500">{{ $item->status }}</p>
        </div>
        @endforeach
    </div>
</div>

<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            datasets: [{
                label: 'تعداد کمک‌ها',
                data: [
                    {{ $monthlyStats->where('month', 1)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 2)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 3)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 4)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 5)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 6)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 7)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 8)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 9)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 10)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 11)->first()->count ?? 0 }},
                    {{ $monthlyStats->where('month', 12)->first()->count ?? 0 }}
                ],
                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection