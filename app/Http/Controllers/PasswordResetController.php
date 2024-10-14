<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function showResetForm()
    {
        return view('auth.passwords.email');  // form buat masukin email
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // sementara aku bikin tokennya random dulu
        $token = Str::random(60);

        //tokennya jd dimaukin tbel forget pass
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        //ngirim email forget pass
        Mail::to($user->email)->send(new ResetPasswordMail($token));

        return back()->with('message', 'Link forget password telah dikirimkan ke email anda.');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);  //form reset password
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        //sesuaiin token di db dulu
        $passwordReset = DB::table('password_resets')->where([
            ['token', $request->token],
            ['email', $request->email],
        ])->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token atau email anda tidak valid.']);
        }

        // pass di update
        $user = User::where('email', $request->email)->first();
        $user->update(['password' => bcrypt($request->password)]);

        // klo sukses, token dihapus
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('message', 'Password anda berhasil diubah!');
    }
}
