<?php

namespace App\Http\Controllers;

use Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;

class OauthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Validate UGM email domain
            $email = $googleUser->email;

            if (!preg_match('/^[a-zA-Z0-9._%+-]+@mail\.ugm\.ac\.id$/', $email)) {
                return redirect()->route('login')
                    ->with('error', 'Anda harus menggunakan email resmi UGM (@mail.ugm.ac.id) untuk login.');
            }

            // Check if user exists
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'email' => $email,
                    'no_hp' => '', // This can be updated later by the user
                    'password' => bcrypt(Str::random(16)), // Random secure password
                    'level' => 'user', // Default level, can be changed by admin
                    'gauth_id' => $googleUser->id,
                ]);
            } else {
                // Update Google Auth ID if not set
                if (!$user->gauth_id) {
                    $user->gauth_id = $googleUser->id;
                    $user->save();
                }
            }

            // Login the user
            Auth::login($user);

            // Redirect based on user level
            switch ($user->level) {
                case 'admin':
                    $route = 'home-admin';
                    break;
                case 'asesor':
                    $route = 'home-asesor';
                    break;
                case 'asesi':
                    $route = 'home-asesi';
                    break;
                default:
                    $route = 'home';
            }

            return redirect()->route($route)
                ->with('success', 'Login berhasil! Selamat datang, ' . ucfirst($user->level) . '!');

        } catch (Exception $e) {
            // Log the error
            \Log::error('Google OAuth error: ' . $e->getMessage());

            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }
}
