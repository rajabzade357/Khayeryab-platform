<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSettingController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.settings.index', compact('admins'));
    }

    public function addAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return back()->with('success', 'ادمین جدید اضافه شد.');
    }

    public function removeAdmin($id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        
        if (User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'حداقل یک ادمین باید وجود داشته باشد.');
        }

        $admin->delete();
        return back()->with('success', 'ادمین حذف شد.');
    }
}