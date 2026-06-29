<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DonorRegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register-donor');
    }

    public function register(Request $request)
    {
        // اعتبارسنجی
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
          
        ]);

        // ایجاد کاربر
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => 'donor',
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

     


        // هدایت به تایید شماره 
       Auth::login($user);
      return redirect()->route('verify.phone.form');
        
    }
}