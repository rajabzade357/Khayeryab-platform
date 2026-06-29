<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class AdminDonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with(['donor', 'charity']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $donations = $query->latest()->paginate(20);

        return view('admin.donations.index', compact('donations'));
    }

    public function show($id)
    {
        $donation = Donation::with(['donor', 'charity'])->findOrFail($id);
        return view('admin.donations.show', compact('donation'));
    }

    public function updateStatus(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        $donation->status = $request->status;
        $donation->save();
        $request->validate([
    'status' => 'required|in:waiting_for_charity,waiting_for_donor,waiting_for_vehicle,delivered,vehicle_delivered,rejected,not_delivered',
]);
        return back()->with('success', 'وضعیت کمک بروزرسانی شد.');
    }
}