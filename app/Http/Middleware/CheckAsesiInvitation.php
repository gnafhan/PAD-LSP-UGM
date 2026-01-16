<?php

namespace App\Http\Middleware;

use App\Services\AccessControlService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckAsesiInvitation Middleware
 * 
 * Ensures that only invited asesi can access protected routes.
 * Verifies email exists in EventParticipant records and registration is complete.
 * 
 * Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 12.2, 12.3
 */
class CheckAsesiInvitation
{
    /**
     * @var AccessControlService
     */
    protected $accessControl;

    /**
     * Create a new middleware instance.
     *
     * @param AccessControlService $accessControl
     */
    public function __construct(AccessControlService $accessControl)
    {
        $this->accessControl = $accessControl;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Requirement 6.1: Check if user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Requirement 6.1, 6.2: Check if user is invited
        if (!$this->accessControl->isEmailInvited($user->email)) {
            Auth::logout();
            return redirect()->route('login')->with('error', 
                'Your email is not registered for any event. Please contact the administrator.');
        }

        // Requirement 6.3, 6.4: Check if user has completed registration
        if (!$this->accessControl->canAccessAssessment($user)) {
            return redirect()->route('asesi.registration.start');
        }

        return $next($request);
    }
}

