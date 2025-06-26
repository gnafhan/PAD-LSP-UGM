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
            'email' => [
                'required',
                'email',
                'max:250',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@(mail\.ugm\.ac\.id|ugm\.ac\.id)$/' // Validasi email UGM
            ],
            'no_hp' => 'required|string|max:20|unique:users',
            'password' => 'required|min:6|confirmed',
            'level' => 'nullable|in:admin,asesor,user',
            'nik' => 'nullable|string|size:16|unique:users',
            'alamat' => 'nullable|string|max:255',
        ], [
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id) atau (@ugm.ac.id)',
            'nik.size' => 'NIK harus 16 digit.',
            'level.in' => 'Role yang dipilih tidak valid.'
        ]);

        if ($request->level == null) {
            $request->level = 'user'; // Set default level to 'user' if not provided
        }

        User::create([
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
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
