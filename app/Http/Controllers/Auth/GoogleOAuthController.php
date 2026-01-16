<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AccessControlService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 * GoogleOAuthController
 * 
 * Handles Google OAuth authentication for the event-based invitation system.
 * Only invited users (those in EventParticipant table) can log in.
 * 
 * Requirements: 5.1, 5.2, 5.3, 5.4, 5.5, 5.6, 7.6
 */
class GoogleOAuthController extends Controller
{
    /**
     * @var AccessControlService
     */
    private AccessControlService $accessControl;

    /**
     * Constructor
     *
     * @param AccessControlService $accessControl
     */
    public function __construct(AccessControlService $accessControl)
    {
        $this->accessControl = $accessControl;
    }

    /**
     * Redirect to Google OAuth.
     * 
     * Requirements: 5.1, 5.2
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     * 
     * Requirements: 5.3, 5.4, 5.5, 5.6, 7.6
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            // Retrieve Google user data
            $googleUser = Socialite::driver('google')->user();
            $email = strtolower($googleUser->getEmail());

            // Check if email is invited using AccessControlService
            if (!$this->accessControl->isEmailInvited($email)) {
                // Handle uninvited users with error message
                return redirect()->route('login')->with('error', 
                    'Your email is not registered for any event. Please contact the administrator.');
            }

            // Get participant details
            $participant = $this->accessControl->getParticipantByEmail($email);

            // Find or create user account
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Create new user with Google data auto-population
                $user = User::create([
                    'name' => $googleUser->getName() ?: $googleUser->getEmail(),
                    'email' => $email,
                    'gauth_id' => $googleUser->getId(),
                    'gauth_type' => 'google',
                    'level' => 'asesi',
                    'password' => bcrypt(Str::random(32)), // Random password
                ]);
            } else {
                // Update Google auth credentials and name
                $user->update([
                    'name' => $googleUser->getName() ?: ($user->name ?: $googleUser->getEmail()), // Update name from Google, fallback to existing or email
                    'gauth_id' => $googleUser->getId(),
                    'gauth_type' => 'google',
                ]);
            }

            // Login user
            Auth::login($user);

            // Check registration status and redirect appropriately
            if ($participant->invitation_status === 'registered') {
                // Already registered, redirect to assessment dashboard
                return redirect()->route('home-asesi');
            }

            // Not yet registered, redirect to registration flow with pre-populated data
            session([
                'registration_event_id' => $participant->id_event,
                'registration_skema_id' => $participant->id_skema,
            ]);

            return redirect()->route('asesi.registration.start');

        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Authentication failed. Please try again.');
        }
    }
}
