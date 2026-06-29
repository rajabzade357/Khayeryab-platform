<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use App\Models\PreferredItem;
use App\Models\Violation;

class CharityDashboardController extends Controller
{
    public function index()
    {
        return view('charity.dashboard');
    }

    public function getData()
    {
        $user = Auth::user();
        $charity = $user->charity;

        if (!$charity) {
            return response()->json(['error' => 'خیریه یافت نشد'], 404);
        }

        $donations = Donation::where('charity_id', $charity->id)
            ->with('donor')
            ->get()
            ->map(function ($donation) {
                return [
                    'id' => $donation->id,
                    'title' => $donation->title,
                    'description' => $donation->description,
                    'donor_name' => $donation->donor ? $donation->donor->name : 'نامشخص',
                    'address' => $donation->donor ? $donation->donor->address : 'نامشخص',
                    'phone' => $donation->donor ? $donation->donor->phone : 'نامشخص',
                    'mobile' => $donation->donor ? $donation->donor->mobile : 'نامشخص',
                    'category' => $donation->category,
                    'delivery_method' => $donation->delivery_method,
                    'pickup_date' => $donation->pickup_date ? $donation->pickup_date->format('Y/m/d') : '-',
                    'status' => $donation->status,
                    'rejection_reason' => $donation->rejection_reason,
                ];
            });

        $stats = [
            'total' => $donations->count(),
            'delivered' => $donations->where('status', 'delivered')->count(),
            'vehicle_delivered' => $donations->where('status', 'vehicle_delivered')->count(),
            'rejected' => $donations->where('status', 'rejected')->count(),
            'waiting_for_charity' => $donations->where('status', 'waiting_for_charity')->count(),
            'waiting_for_donor' => $donations->where('status', 'waiting_for_donor')->count(),
            'waiting_for_vehicle' => $donations->where('status', 'waiting_for_vehicle')->count(),
            'not_delivered' => $donations->where('status', 'not_delivered')->count(),
        ];

        $preferredItems = PreferredItem::where('charity_id', $charity->id)->get();

        return response()->json([
            'donations' => $donations,
            'stats' => $stats,
            'preferredItems' => $preferredItems,
        ]);
    }

    // تأیید اهدا - بر اساس روش تحویل
    public function approveDonation($id)
    {
        $charity = Auth::user()->charity;
        $donation = Donation::where('id', $id)->where('charity_id', $charity->id)->firstOrFail();

        $donation->status = $donation->delivery_method === 'donor_location' 
            ? 'waiting_for_donor' 
            : 'waiting_for_vehicle';

        $donation->save();

        return response()->json(['success' => true, 'message' => 'اهدا تأیید شد.']);
    }

    // رد اهدا
    public function rejectDonation(Request $request, $id)
    {
        $charity = Auth::user()->charity;
        $donation = Donation::where('id', $id)->where('charity_id', $charity->id)->firstOrFail();

        $donation->status = 'rejected';
        $donation->rejection_reason = $request->reason ?? 'دلیل مشخص نشده';
        $donation->save();

        return response()->json(['success' => true, 'message' => 'اهدا رد شد.']);
    }

    // تحویل داده شد
    public function markDelivered($id)
    {
        $charity = Auth::user()->charity;
        $donation = Donation::where('id', $id)->where('charity_id', $charity->id)->firstOrFail();
        $donation->status = 'delivered';
        $donation->save();

        return response()->json(['success' => true, 'message' => 'تحویل داده شد.']);
    }

    // توسط خودرو تحویل گرفته شد
    public function markVehicleDelivered($id)
    {
        $charity = Auth::user()->charity;
        $donation = Donation::where('id', $id)->where('charity_id', $charity->id)->firstOrFail();
        $donation->status = 'vehicle_delivered';
        $donation->save();

        return response()->json(['success' => true, 'message' => 'توسط خودرو تحویل گرفته شد.']);
    }

    // تحویل داده نشد + دلیل + امتیاز منفی
    public function markNotDelivered(Request $request, $id)
    {
        $charity = Auth::user()->charity;
        $donation = Donation::where('id', $id)->where('charity_id', $charity->id)->firstOrFail();

        $reason = $request->reason;
        $reasonText = match($reason) {
            'not_present' => 'پاسخگو نبود / تحویل نداد',
            'inappropriate' => 'جنس نامناسب',
            default => 'نامشخص',
        };

        $donation->status = 'not_delivered';
        $donation->rejection_reason = $reasonText;
        $donation->save();

        // امتیاز منفی برای خیر
        if ($donation->donor) {
            $donation->donor->increment('violation_count');

            Violation::create([
                'user_id' => $donation->donor_id,
                'admin_id' => Auth::id(),
                'count' => 1,
                'reason' => $reasonText,
                'type' => 'auto',
            ]);
        }

        return response()->json(['success' => true, 'message' => 'تحویل داده نشد ثبت شد.']);
    }

    // لغو تأیید - بازگشت به waiting_for_charity
    public function undoApproval($id)
    {
        $charity = Auth::user()->charity;
        $donation = Donation::where('id', $id)->where('charity_id', $charity->id)->firstOrFail();
        $donation->status = 'waiting_for_charity';
        $donation->save();

        return response()->json(['success' => true, 'message' => 'تأیید لغو شد.']);
    }

    // لغو رد - بازگشت به waiting_for_charity
    public function undoReject($id)
    {
        $charity = Auth::user()->charity;
        $donation = Donation::where('id', $id)->where('charity_id', $charity->id)->firstOrFail();
        $donation->status = 'waiting_for_charity';
        $donation->rejection_reason = null;
        $donation->save();

        return response()->json(['success' => true, 'message' => 'رد لغو شد.']);
    }

    // افزودن وسایل ترجیحی
    public function addPreferredItem(Request $request)
    {
        $charity = Auth::user()->charity;

        $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|in:high,medium,normal',
        ]);

        $item = PreferredItem::create([
            'charity_id' => $charity->id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);

        return response()->json(['success' => true, 'item' => $item]);
    }

    // حذف وسیله ترجیحی
    public function deletePreferredItem($id)
    {
        $charity = Auth::user()->charity;
        $item = PreferredItem::where('id', $id)->where('charity_id', $charity->id)->firstOrFail();
        $item->delete();

        return response()->json(['success' => true]);
    }
}