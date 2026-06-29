<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Charity;
use App\Models\Donation;


class DonorDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // دریافت اهداهای این خیر
        $donations = $user->donations()->with('charity.user')->get();

        // کارت‌های آماری
        $totalDonations = $donations->count();
        $approvedCount = $donations->where('status', 'approved')->count();
        $rejectedCount = $donations->where('status', 'rejected')->count();
        $waitingCharityCount = $donations->where('status', 'waiting_for_charity')->count();
        $waitingDonorCount = $donations->where('status', 'waiting_for_donor')->count();
        $violationCount = $user->violation_count;

        // لیست خیریه‌های تأیید شده برای فرم اهدا
        $charities = Charity::where('is_approved', true)->with('user')->get();

        return view('donor.dashboard', compact(
            'donations',
            'totalDonations',
            'approvedCount',
            'rejectedCount',
            'waitingCharityCount',
            'waitingDonorCount',
            'violationCount',
            'charities'
        ));
    }
    
    // متد ثبت اهدا
    public function storeDonation(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:small,large',
            'charity_id' => 'required|exists:charities,id',
            'delivery_method' => 'required|in:charity_location,donor_location',
            'pickup_date' => 'nullable|date',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('donations', 'public');
            }
        }

        Donation::create([
            'donor_id' => Auth::id(),
            'charity_id' => $request->charity_id,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'delivery_method' => $request->delivery_method,
            'pickup_date' => $request->pickup_date,
            'images' => json_encode($images),
            'status' => 'waiting_for_charity',
        ]);

        return redirect()->route('donor.dashboard')->with('success', 'اهدای شما با موفقیت ثبت شد.');
    }

}