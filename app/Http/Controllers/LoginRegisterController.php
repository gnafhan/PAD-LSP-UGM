<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginRegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:250|unique:users',
            'no_hp' => 'required|string|max:20|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'level' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }


     public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Cek level user setelah login
            $user = Auth::user();
            switch ($user->level) {
                case 'admin':
                    return redirect()->route('home-admin')->with('success', 'Welcome, Admin!');
                case 'asesor':
                    return redirect()->route('home-asesor')->with('success', 'Welcome, Asesor!');
                case 'asesi':
                    return redirect()->route('home-asesi')->with('success', 'Welcome, Asesi!');
                default:
                    return redirect()->route('home')->with('success', 'Welcome, User!');
            }
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
