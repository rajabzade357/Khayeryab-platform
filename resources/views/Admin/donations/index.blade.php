@extends('admin.layouts.admin')

@section('title', 'مدیریت کمک‌ها')

@section('content')
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h3 class="text-xl font-bold text-gray-800">لیست کمک‌ها</h3>
    </div>
    <div class="p-6">
        <form method="GET" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجو..." class="flex-1 border rounded-lg p-2">
            <select name="status" class="border rounded-lg p-2">
                <option value="">همه وضعیت‌ها</option>
                <option value="waiting_for_charity">در انتظار خیریه</option>
                <option value="accepted_by_charity">پذیرفته شده</option>
                <option value="delivered">تحویل داده شده</option>
                <option value="rejected">رد شده</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">فیلتر</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-right">عنوان</th>
                        <th class="p-3 text-right">خیر</th>
                        <th class="p-3 text-right">خیریه</th>
                        <th class="p-3 text-right">دسته‌بندی</th>
                        <th class="p-3 text-right">وضعیت</th>
                        <th class="p-3 text-right">تاریخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($donations as $donation)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 font-bold">{{ $donation->title }}</td>
                        <td class="p-3">{{ $donation->donor->name ?? '-' }}</td>
                        <td class="p-3">{{ $donation->charity->user->name ?? '-' }}</td>
                        <td class="p-3">{{ $donation->category === 'small' ? 'کوچک' : 'بزرگ' }}</td>


                        <td class="p-3">

            
                            @php
                            $statusColors = [
                                'waiting_for_charity' => 'bg-yellow-100 text-yellow-700',
                                'waiting_for_donor' => 'bg-purple-100 text-purple-700',
                                'waiting_for_vehicle' => 'bg-orange-100 text-orange-700',
                                'delivered' => 'bg-green-100 text-green-700',
                                'vehicle_delivered' => 'bg-teal-100 text-teal-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'not_delivered' => 'bg-gray-100 text-gray-700',
                            ];
                            @endphp


                            @php
                            $statusLabels = [
                                'waiting_for_charity' => 'در انتظار خیریه',
                                'waiting_for_donor' => 'منتظر خیر',
                                'waiting_for_vehicle' => 'منتظر خودرو',
                                'delivered' => 'تحویل داده شد',
                                'vehicle_delivered' => 'خودرو تحویل گرفت',
                                'rejected' => 'رد شده',
                                'not_delivered' => 'تحویل نشده',
                            ];
                            @endphp

                                <span class="px-2 py-1 rounded-full text-xs {{ $statusColors[$donation->status] ?? 'bg-gray-100' }}">
                                    {{ $statusLabels[$donation->status] ?? $donation->status }}
                                </span>
                        </td>
                        
                        <td class="p-3 text-sm">{{ $donation->created_at->format('Y/m/d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $donations->links() }}</div>
    </div>
</div>
@endsection