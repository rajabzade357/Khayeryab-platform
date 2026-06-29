<?php

namespace App\Http\Controllers;

use App\Models\Charity;
use App\Models\PreferredItem;
use Illuminate\Http\Request;

class PublicCharityController extends Controller
{
    public function index(Request $request)
    {
        $query = Charity::where('is_approved', true)->with('user', 'preferredItems');

        // فیلتر بر اساس شهر
        if ($request->filled('city')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        // جستجو بر اساس نام خیریه
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $charities = $query->paginate(12);
        $cities = \App\Models\User::where('role', 'charity')
            ->whereHas('charity', function ($q) {
                $q->where('is_approved', true);
            })
            ->distinct()
            ->pluck('city');

        return view('public.charities', compact('charities', 'cities'));
    }
}