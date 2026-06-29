<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Charity;
use App\Models\Donation;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_charities' => Charity::count(),
            'total_donors' => User::where('role', 'donor')->count(),
            'total_donations' => Donation::count(),
            'pending_charities' => Charity::where('is_approved', false)->count(),
            'active_donations' => Donation::whereIn('status', ['waiting_for_charity', 'accepted_by_charity'])->count(),
            'completed_donations' => Donation::where('status', 'delivered')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_donations' => Donation::with(['donor', 'charity'])->latest()->take(5)->get(),
        ];

        $monthlyStats = Donation::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $reportStats = [
            'total_donors' => User::where('role', 'donor')->count(),
            'active_donors' => User::where('role', 'donor')->where('is_active', true)->count(),
            'total_charities' => Charity::count(),
            'approved_charities' => Charity::where('is_approved', true)->count(),
            'pending_charities' => Charity::where('is_approved', false)->count(),
            'total_donations' => Donation::count(),
            'completed_donations' => Donation::where('status', 'delivered')->count(),
            'donations_by_status' => Donation::select('status', DB::raw('COUNT(*) as count'))
                ->groupBy('status')->get(),
        ];

        return view('admin.dashboard', compact('stats', 'monthlyStats', 'reportStats'));
    }

    public function chartData()
    {
        $monthly = Donation::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($monthly);
    }
}