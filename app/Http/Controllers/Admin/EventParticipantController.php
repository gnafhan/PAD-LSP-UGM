<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Skema;
use App\Services\ParticipantManagementService;
use App\Exceptions\DuplicateEmailException;
use App\Exceptions\InvalidEmailException;
use Illuminate\Http\Request;

/**
 * EventParticipantController
 * 
 * Handles admin operations for managing event participants including
 * adding, updating, and removing participants from events.
 * 
 * Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 2.4, 2.5, 2.6, 2.8, 9.1, 9.2, 9.3, 9.4, 12.1
 */
class EventParticipantController extends Controller
{
    protected ParticipantManagementService $participantService;

    public function __construct(ParticipantManagementService $participantService)
    {
        $this->participantService = $participantService;
    }

    /**
     * Show participant management page for event
     * 
     * Requirements: 1.1, 1.6, 10.1
     */
    public function index(string $eventId)
    {
        $event = Event::with('tuk')->findOrFail($eventId);
        $participantsBySkema = $this->participantService->getParticipantsBySkema($eventId);
        $skemas = Skema::all();

        return view('home.home-admin.event-participants-enhanced', compact(
            'event',
            'participantsBySkema',
            'skemas'
        ));
    }

    /**
     * Add single participant
     * 
     * Requirements: 1.2, 1.3, 1.4
     */
    public function store(Request $request, string $eventId)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'id_skema' => 'required|exists:skema,id_skema',
        ]);

        try {
            $participant = $this->participantService->addParticipant(
                $eventId,
                $validated['id_skema'],
                $validated['email']
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Participant added and invitation queued',
                    'participant' => [
                        'id' => $participant->id,
                        'email' => $participant->email,
                        'invitation_status' => $participant->invitation_status,
                    ]
                ]);
            }

            return redirect()->back()->with('success', 'Participant added and invitation queued');
        } catch (DuplicateEmailException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->withErrors(['email' => $e->getMessage()]);
        } catch (InvalidEmailException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->withErrors(['email' => $e->getMessage()]);
        }
    }

    /**
     * Add bulk participants
     * 
     * Requirements: 2.4, 2.5, 2.6, 2.8
     */
    public function storeBulk(Request $request, string $eventId)
    {
        $validated = $request->validate([
            'emails' => 'required|string',
            'id_skema' => 'required|exists:skema,id_skema',
        ]);

        // Parse emails (comma or space separated)
        $emails = preg_split('/[\s,]+/', $validated['emails'], -1, PREG_SPLIT_NO_EMPTY);

        try {
            $participants = $this->participantService->addBulkParticipants(
                $eventId,
                $validated['id_skema'],
                $emails
            );

            if ($request->expectsJson()) {
                // Convert array to collection for mapping
                $participantsData = collect($participants)->map(fn($p) => [
                    'id' => $p->id,
                    'email' => $p->email,
                    'invitation_status' => $p->invitation_status,
                ])->toArray();

                return response()->json([
                    'success' => true,
                    'message' => count($participants) . ' participants added and invitations queued',
                    'count' => count($participants),
                    'participants' => $participantsData
                ]);
            }

            return redirect()->back()->with('success', count($participants) . ' participants added and invitations queued');
        } catch (DuplicateEmailException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->withErrors(['emails' => $e->getMessage()]);
        } catch (InvalidEmailException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return redirect()->back()->withErrors(['emails' => $e->getMessage()]);
        }
    }

    /**
     * Check invitation status for participants
     * 
     * Returns the current invitation status for specified participants
     */
    public function checkStatus(Request $request, string $eventId)
    {
        $validated = $request->validate([
            'participant_ids' => 'required|array',
            'participant_ids.*' => 'integer|exists:event_participants,id',
        ]);

        $participants = EventParticipant::whereIn('id', $validated['participant_ids'])
            ->select('id', 'email', 'invitation_status', 'invitation_sent_at')
            ->get();

        return response()->json([
            'success' => true,
            'participants' => $participants
        ]);
    }

    /**
     * Update participant skema
     * 
     * Requirements: 9.1, 9.2, 9.3, 9.4
     */
    public function update(Request $request, string $eventId, int $participantId)
    {
        $validated = $request->validate([
            'id_skema' => 'required|exists:skema,id_skema',
        ]);

        try {
            $this->participantService->updateParticipantSkema(
                $participantId,
                $validated['id_skema']
            );

            return redirect()->back()->with('success', 'Participant updated and new invitation sent');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove participant
     * 
     * Requirements: 1.5, 12.1
     */
    public function destroy(string $eventId, int $participantId)
    {
        try {
            $this->participantService->removeParticipant($participantId);
            return redirect()->back()->with('success', 'Participant removed and access revoked');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
