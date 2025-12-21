<?php

namespace App\Http\Controllers;

use App\Models\RincianAsesmen;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\IA02Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TugasPesertaController extends Controller
{
    public function index(Request $request)
    {
        $currentAsesor = Auth::user()->asesor;
        
        if (!$currentAsesor) {
            return redirect()->route('home-asesor')->with('error', 'Data asesor tidak ditemukan');
        }

        // Get daftar asesi yang di-assign ke asesor ini dengan data tugas
        $daftarAsesi = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])->where('id_asesor', $currentAsesor->id_asesor)->get();

        // Add task count and status for each asesi manually
        $daftarAsesi = $daftarAsesi->map(function ($rincian) use ($currentAsesor) {
            $tasks = IA02Tugas::where('id_asesi', $rincian->id_asesi)
                ->where('id_asesor', $currentAsesor->id_asesor)
                ->get();
                
            $rincian->setAttribute('task_count', $tasks->count());
            
            // Calculate status
            $allReviewed = true;
            $hasRejected = false;
            
            if ($tasks->count() > 0) {
                foreach ($tasks as $task) {
                    if (in_array($task->status, ['submitted', 'draft'])) {
                        $allReviewed = false;
                        break;
                    }
                    if ($task->status === 'rejected') {
                        $hasRejected = true;
                    }
                }
            } else {
                $allReviewed = false;
            }
            
            $rincian->setAttribute('all_reviewed', $allReviewed);
            $rincian->setAttribute('has_rejected', $hasRejected);
            
            return $rincian;
        });

        // Check if specific asesi is selected
        $detailRincian = null;
        $notFound = false;
        $tugasData = [];
        
        if ($request->has('id_asesi')) {
            $detailRincian = $daftarAsesi->where('id_asesi', $request->id_asesi)->first();
            
            if (!$detailRincian) {
                $notFound = true;
            } else {
                // Load submitted tasks for this asesi
                $tugasData = $this->getTugasData($request->id_asesi, $currentAsesor->id_asesor);
            }
        }

        return view('home.home-asesor.tugas-peserta', compact(
            'daftarAsesi', 
            'detailRincian', 
            'notFound',
            'tugasData'
        ));
    }

    public function store(Request $request)
    {
        try {
            $currentAsesor = Auth::user()->asesor;
            
            if (!$currentAsesor) {
                return redirect()->route('tugas-peserta')->with('error', 'Data asesor tidak ditemukan');
            }

            // Validasi basic
            $request->validate([
                'id_asesi' => 'required|string',
                'tugas_observasi' => 'required|string',
                'tugas_portofolio' => 'required|string', 
                'tugas_simulasi' => 'required|string',
                'tugas_tanya_jawab' => 'required|string',
                'tugas_tertulis' => 'required|string',
                'tugas_lainnya' => 'nullable|string'
            ]);

            // Validasi asesor access secara manual
            $rincianAsesmen = RincianAsesmen::with(['asesi'])
                ->where('id_asesi', $request->id_asesi)
                ->where('id_asesor', $currentAsesor->id_asesor)
                ->first();

            if (!$rincianAsesmen) {
                return redirect()->route('tugas-peserta')
                    ->with('error', 'Data asesi tidak ditemukan atau Anda tidak memiliki akses');
            }

            $asesi = $rincianAsesmen->asesi;
            if (!$asesi) {
                return redirect()->route('tugas-peserta')
                    ->with('error', 'Data asesi tidak ditemukan');
            }

            // Simpan tugas (untuk saat ini kita simpan sebagai log atau session)
            // Dalam implementasi real, buat model TugasPeserta
            $tugasData = [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $currentAsesor->id_asesor,
                'tugas_observasi' => $request->tugas_observasi,
                'tugas_portofolio' => $request->tugas_portofolio,
                'tugas_simulasi' => $request->tugas_simulasi,
                'tugas_tanya_jawab' => $request->tugas_tanya_jawab,
                'tugas_tertulis' => $request->tugas_tertulis,
                'tugas_lainnya' => $request->tugas_lainnya,
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Simpan ke session sementara (dalam implementasi real, simpan ke database)
            session(['tugas_peserta_' . $request->id_asesi => $tugasData]);

            Log::info('Tugas peserta disimpan', [
                'id_asesi' => $request->id_asesi,
                'asesor_id' => $currentAsesor->id_asesor,
                'asesi_name' => $asesi->nama_asesi
            ]);

            return redirect()->route('tugas-peserta', ['id_asesi' => $request->id_asesi])
                ->with('success', 'Tugas peserta berhasil disimpan');

        } catch (\Exception $e) {
            Log::error('Error saving tugas peserta: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan tugas peserta: ' . $e->getMessage());
        }
    }

    public function generatePdf($id_asesi)
    {
        try {
            $currentAsesor = Auth::user()->asesor;
            
            if (!$currentAsesor) {
                return redirect()->route('tugas-peserta')->with('error', 'Data asesor tidak ditemukan');
            }

            // Validasi akses secara manual
            $detailRincian = RincianAsesmen::with([
                'asesi.skema',
                'asesor',
                'event.tuk'
            ])->where('id_asesi', $id_asesi)
              ->where('id_asesor', $currentAsesor->id_asesor)
              ->first();

            if (!$detailRincian) {
                return redirect()->route('tugas-peserta')
                    ->with('error', 'Data asesi tidak ditemukan atau Anda tidak memiliki akses');
            }

            $tugasData = $this->getTugasData($id_asesi, $currentAsesor->id_asesor);

            // Generate PDF view
            return view('home.home-asesor.tugas-peserta-pdf', compact('detailRincian', 'tugasData'));

        } catch (\Exception $e) {
            Log::error('Error generating PDF tugas peserta: ' . $e->getMessage());
            
            return redirect()->route('tugas-peserta')
                ->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }

    public function downloadFile($id)
    {
        try {
            $currentAsesor = Auth::user()->asesor;
            
            if (!$currentAsesor) {
                return redirect()->back()->with('error', 'Data asesor tidak ditemukan');
            }

            // Get the task and verify it belongs to this asesor
            $task = IA02Tugas::where('id', $id)
                ->where('id_asesor', $currentAsesor->id_asesor)
                ->where('jenis_evidence', '3') // Only file uploads
                ->firstOrFail();

            if (!$task->file_path || !Storage::exists($task->file_path)) {
                return redirect()->back()->with('error', 'File tidak ditemukan.');
            }

            return Storage::download($task->file_path, $task->file_name);

        } catch (\Exception $e) {
            Log::error('Error downloading file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh file.');
        }
    }

    public function updateTaskStatus(Request $request, $id)
    {
        try {
            $currentAsesor = Auth::user()->asesor;
            
            if (!$currentAsesor) {
                return redirect()->back()->with('error', 'Data asesor tidak ditemukan');
            }

            $request->validate([
                'status' => 'required|in:reviewed,approved,rejected',
                'catatan_asesor' => 'nullable|string|max:1000',
                'nilai' => 'nullable|numeric|min:0|max:100'
            ]);

            $task = IA02Tugas::where('id', $id)
                ->where('id_asesor', $currentAsesor->id_asesor)
                ->firstOrFail();

            $task->update([
                'status' => $request->status,
                'catatan_asesor' => $request->catatan_asesor,
                'nilai' => $request->nilai
            ]);

            return redirect()->back()->with('success', 'Status tugas berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error updating task status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui status tugas.');
        }
    }

    /**
     * Get tugas data for specific asesi - now includes submitted tasks from IA02Tugas
     */
    private function getTugasData($id_asesi, $id_asesor)
    {
        // Get submitted tasks from database
        $submittedTasks = IA02Tugas::with(['asesi', 'skema'])
            ->where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->orderBy('waktu_submit', 'desc')
            ->get();

        // Get session data for form fields (existing functionality)
        $sessionData = session('tugas_peserta_' . $id_asesi, []);

        // Combine both data
        return [
            'submitted_tasks' => $submittedTasks,
            'form_data' => $sessionData ?: [
                'tugas_observasi' => '',
                'tugas_portofolio' => '',
                'tugas_simulasi' => '',
                'tugas_tanya_jawab' => '',
                'tugas_tertulis' => '',
                'tugas_lainnya' => ''
            ]
        ];
    }

    /**
     * Complete assessment and mark progress for IA02
     */
    public function completeAssessment(Request $request)
    {
        try {
            $currentAsesor = Auth::user()->asesor;
            
            if (!$currentAsesor) {
                return redirect()->back()->with('error', 'Data asesor tidak ditemukan');
            }

            $request->validate([
                'id_asesi' => 'required|string'
            ]);

            // Verify all tasks are approved
            $tasks = IA02Tugas::where('id_asesi', $request->id_asesi)
                ->where('id_asesor', $currentAsesor->id_asesor)
                ->get();

            if ($tasks->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada tugas yang ditemukan untuk asesi ini.');
            }

            $allApproved = $tasks->every(fn($task) => $task->status === 'approved');
            
            if (!$allApproved) {
                return redirect()->back()->with('error', 'Semua tugas harus berstatus "Approved" sebelum dapat menyelesaikan penilaian.');
            }

            // Mark tugas_peserta progress as complete using ProgressTrackingService
            $progressService = app(\App\Services\ProgressTrackingService::class);
            $progressService->completeStep(
                $request->id_asesi,
                'tugas_peserta',
                'Completed by Asesor: ' . $currentAsesor->id_asesor . ' - All tasks approved'
            );

            Log::info('Tugas Peserta assessment completed', [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $currentAsesor->id_asesor,
                'tasks_count' => $tasks->count()
            ]);

            return redirect()->route('tugas-peserta', ['id_asesi' => $request->id_asesi])
                ->with('success', 'Penilaian tugas berhasil diselesaikan! Progress Tugas Peserta telah ditandai selesai.');

        } catch (\Exception $e) {
            Log::error('Error completing assessment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyelesaikan penilaian: ' . $e->getMessage());
        }
    }
}
