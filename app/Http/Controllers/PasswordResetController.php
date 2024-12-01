<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PasswordResets;

class PasswordResetController extends Controller
{
    public function showResetForm()
    {
        return view('auth.password.forget-password');  // form buat masukin email abis klik forget password
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // sementara aku bikin tokennya random dulu
        $token = rand(100000, 999999);
        // $user->token = $token;
        // $user->save();

        PasswordResets::create([
            'email' => $request->email,
            'id_user' => auth()->user()->id_user,
            'token' => $token,
            'created_at' => now(),
        ]);

        //ngirim email forget pass
        // Mail::to($user->email)->send(new ResetPasswordMail($token));

        Mail::send('auth.password.email', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'Link forget password telah dikirimkan ke email anda.');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.password.reset-password', ['token' => $token]);  //form reset password abis isi token, pass baru
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $passwordReset = PasswordResets::where([
            ['token', $request->token],
            ['email', $request->email],
        ])->first();

        // Jika token atau email tidak valid
        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token atau email anda tidak valid.']);
        }

        // Ambil pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);

            PasswordResets::where('email', $request->email)->delete();

            return redirect('/login')->with('message', 'Password anda berhasil diubah!');
        }

        return back()->withErrors(['email' => 'Pengguna tidak ditemukan.']);
    }

}
