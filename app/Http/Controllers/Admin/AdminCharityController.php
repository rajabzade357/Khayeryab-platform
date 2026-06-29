<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Charity;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCharityController extends Controller
{
    public function index(Request $request)
    {
        $query = Charity::with('user');

        if ($request->status === 'pending') {
            $query->where('is_approved', false);
        } elseif ($request->status === 'approved') {
            $query->where('is_approved', true);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('registration_number', 'like', '%' . $request->search . '%');
        }

        $charities = $query->latest()->paginate(20);

        return view('admin.charities.index', compact('charities'));
    }

    public function show($id)
    {
        $charity = Charity::with(['user', 'donations', 'preferredItems'])->findOrFail($id);
        return view('admin.charities.show', compact('charity'));
    }

    public function approve($id)
    {
        $charity = Charity::findOrFail($id);
        $charity->is_approved = true;
        $charity->save();

        return back()->with('success', 'خیریه با موفقیت تأیید شد.');
    }

    public function reject($id)
    {
        $charity = Charity::findOrFail($id);
        $charity->is_approved = false;
        $charity->save();

        return back()->with('success', 'خیریه رد شد.');
    }

    public function toggleActive($id)
    {
        $charity = Charity::findOrFail($id);
        $user = $charity->user;
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'فعال' : 'غیرفعال';
        return back()->with('success', "خیریه {$status} شد.");
    }
}