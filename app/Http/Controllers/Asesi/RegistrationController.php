<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;
use App\Services\AccessControlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * RegistrationController
 * 
 * Handles asesi registration flow for invited participants.
 * Pre-populates event and skema from invitation.
 * 
 * Requirements: 6.1, 6.2, 7.1, 7.2, 7.4, 7.5, 7.7
 */
class RegistrationController extends Controller
{
    public function __construct(
        private AccessControlService $accessControl
    ) {
        $this->middleware('auth');
    }

    /**
     * Show registration start page.
     * 
     * Verifies user is invited, gets participant details,
     * checks if already registered, loads event and skema,
     * and returns registration view with pre-populated data.
     * 
     * Requirements: 6.1, 6.2, 7.1, 7.2, 7.7
     */
    public function start()
    {
        $user = auth()->user();

        // Verify user is invited
        if (!$this->accessControl->isEmailInvited($user->email)) {
            return redirect()->route('login')->with('error', 'You are not registered for any event.');
        }

        // Get participant details
        $participant = $this->accessControl->getParticipantByEmail($user->email);

        // If already registered, redirect to dashboard
        if ($participant->invitation_status === 'registered') {
            return redirect()->route('home-asesi');
        }

        // Load event and skema
        $event = $participant->event;
        $skema = $participant->skema;

        // Return registration view with pre-populated data
        return view('home.home-asesi.registration.start', compact('event', 'skema', 'user'));
    }

    /**
     * Complete registration and mark as registered.
     * 
     * Marks participant as registered and redirects to assessment dashboard.
     * 
     * Requirements: 7.4, 7.5
     */
    public function complete(Request $request)
    {
        $user = auth()->user();

        // Mark participant as registered
        $this->accessControl->markAsRegistered($user->email);

        return redirect()->route('home-asesi')->with('success', 'Registration completed successfully');
    }
}
