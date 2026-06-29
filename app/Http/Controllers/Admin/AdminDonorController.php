<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDonorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'donor');

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('mobile', 'like', '%' . $request->search . '%');
            });
        }

        $donors = $query->latest()->paginate(20);

        return view('admin.donors.index', compact('donors'));
    }

    public function show($id)
    {
        $donor = User::with(['donations', 'violations'])->findOrFail($id);
        return view('admin.donors.show', compact('donor'));
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'فعال' : 'غیرفعال';
        return back()->with('success', "خیر {$status} شد.");
    }

    public function addViolation(Request $request, $id)
    {
        $request->validate([
            'count' => 'required|integer',
            'reason' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($id);
        
        Violation::create([
            'user_id' => $id,
            'admin_id' => Auth::id(),
            'count' => $request->count,
            'reason' => $request->reason,
            'type' => 'manual',
        ]);

        $user->violation_count += $request->count;
        $user->save();

        return back()->with('success', 'تخلف با موفقیت ثبت شد.');
    }
}