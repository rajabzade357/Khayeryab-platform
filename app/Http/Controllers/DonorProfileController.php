<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('donor.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('donor.profile')->with('success', 'اطلاعات با موفقیت بروزرسانی شد.');
    }
}