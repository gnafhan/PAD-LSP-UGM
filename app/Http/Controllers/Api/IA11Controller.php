<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IA11;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\TandaTanganAsesor;
use App\Services\ProgressTrackingService;
use App\Services\AsesmenValidationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class IA11Controller extends Controller
{
    protected $progressService;
    protected $validationService;

    public function __construct(ProgressTrackingService $progressService, AsesmenValidationService $validationService)
    {
        $this->progressService = $progressService;
        $this->validationService = $validationService;
    }

    /**
     * Get IA11 data for specific asesi
     */
    public function getIA11ForAsesor(Request $request, $asesiId): JsonResponse
    {
        try {
            // Get asesor ID from header
            $asesorId = $request->header('X-Asesor-ID');
            
            Log::info('IA11 API called', [
                'asesiId' => $asesiId,
                'asesorId' => $asesorId,
                'headers' => $request->headers->all()
            ]);
            
            if (!$asesorId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor ID tidak ditemukan dalam header'
                ], 400);
            }

            // Validate asesi exists - updated to match IA02 loading pattern
            $asesi = Asesi::with(['skema', 'rincianAsesmen.asesor', 'rincianAsesmen.event.tuk'])
                ->find($asesiId);

            if (!$asesi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesi tidak ditemukan'
                ], 404);
            }

            // Get IA11 data if it exists
            $ia11 = IA11::with(['skema', 'asesi', 'asesor'])
                ->where('id_asesi', $asesiId)
                ->where('id_asesor', $asesorId)
                ->first();

            if (!$ia11) {
                // Try to find any IA11 for this asesi without asesor filter for debugging
                $anyIA11 = IA11::where('id_asesi', $asesiId)->first();
                Log::info('Debug: Any IA11 for this asesi?', [
                    'any_ia11_found' => !!$anyIA11,
                    'any_ia11_asesor' => $anyIA11 ? $anyIA11->id_asesor : null
                ]);
                
                // Create new IA11 if not exists
                $ia11 = $this->createIA11ForAsesi($asesiId, $asesorId);
            }

            Log::info('IA11 result', [
                'ia11_found' => !!$ia11,
                'ia11_id' => $ia11 ? $ia11->id : null,
                'record_exists' => true
            ]);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'record_exists' => true,
                    'detail_ia11' => [
                        'id' => $ia11->id,
                        'id_asesi' => $ia11->id_asesi,
                        'id_asesor' => $ia11->id_asesor,
                        'id_skema' => $ia11->id_skema,
                        'judul_sertifikasi' => $ia11->judul_sertifikasi,
                        'nomor_skema' => $ia11->nomor_skema, // Using accessor
                        'nama_skema' => $ia11->skema->nama_skema ?? 'N/A',
                        'nama_peserta' => $ia11->nama_peserta,
                        'nama_asesor' => $ia11->nama_asesor,
                        'tuk' => $ia11->tuk, // Using accessor
                        'kegiatan_data' => $ia11->kegiatan_data,
                        'komentar_all' => $ia11->komentar_all,
                        'waktu_tanda_tangan_asesor' => $ia11->waktu_tanda_tangan_asesor ? $ia11->waktu_tanda_tangan_asesor->format('d-m-Y H:i:s') . ' WIB' : null,
                        'waktu_tanda_tangan_asesi' => $ia11->waktu_tanda_tangan_asesi ? $ia11->waktu_tanda_tangan_asesi->format('d-m-Y H:i:s') . ' WIB' : null,
                        'ttd_asesor' => $ia11->ttd_asesor,
                        'ttd_asesi' => $ia11->ttd_asesi,
                        'status' => $ia11->status,
                        'status_label' => $ia11->status_label ?? 'Draft',
                        'is_asesor_signed' => $ia11->waktu_tanda_tangan_asesor !== null,
                        'is_asesi_signed' => $ia11->waktu_tanda_tangan_asesi !== null,
                        'is_completed' => $ia11->waktu_tanda_tangan_asesor !== null && $ia11->waktu_tanda_tangan_asesi !== null,
                        'catatan' => $ia11->catatan,
                        'created_at' => $ia11->created_at,
                        'updated_at' => $ia11->updated_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getIA11ForAsesor: ' . $e->getMessage(), [
                'asesiId' => $asesiId,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data IA11: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save IA11 data
     */
    public function saveIA11(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id_asesi' => 'required|string|exists:asesi,id_asesi',
                'asesor_id' => 'required|string|exists:asesor,id_asesor',
                'kegiatan_data' => 'required|string', // Back to original format
                'komentar_all' => 'nullable|string',
                'waktu_tanda_tangan' => 'required|string',
            ]);

            $asesi = Asesi::with('skema')->find($request->id_asesi);
            $asesor = Asesor::find($request->asesor_id);

            if (!$asesi || !$asesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data asesi atau asesor tidak ditemukan'
                ], 404);
            }

            // Validate kegiatan data
            $kegiatanData = json_decode($request->kegiatan_data, true);
            if (!$kegiatanData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data kegiatan tidak valid'
                ], 422);
            }

            // Get asesor signature
            $signatureFile = null;
            if ($asesor->file_url_tanda_tangan) {
                $signatureFile = basename($asesor->file_url_tanda_tangan);
            }

            $ia11Data = [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->asesor_id,
                'id_skema' => $asesi->id_skema,
                'judul_sertifikasi' => $asesi->skema->nama_skema ?? '',
                'nama_peserta' => $asesi->nama_asesi ?? '',
                'nama_asesor' => $asesor->nama_asesor ?? '',
                'kegiatan_data' => $request->kegiatan_data, // Store as original format
                'komentar_all' => $request->komentar_all,
                'waktu_tanda_tangan_asesor' => $request->waktu_tanda_tangan,
                'ttd_asesor' => $signatureFile,
                'status' => 'completed',
            ];

            $ia11 = IA11::updateOrCreate(
                [
                    'id_asesi' => $request->id_asesi,
                    'id_asesor' => $request->asesor_id,
                    'id_skema' => $asesi->id_skema,
                ],
                $ia11Data
            );

            // Track progress
            $this->progressService->completeStep(
                $request->id_asesi,
                'ia11',
                'Completed by Asesor ID: ' . $request->asesor_id . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Data IA11 berhasil disimpan dan ditandatangani',
                'data' => $ia11
            ]);

        } catch (\Exception $e) {
            Log::error('Error in saveIA11: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data IA11: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new IA11 for asesi - updated to match IA02 style
     */
    private function createIA11ForAsesi($asesiId, $asesorId)
    {
        $asesi = Asesi::with(['skema', 'rincianAsesmen.asesor', 'rincianAsesmen.event.tuk'])->find($asesiId);
        $asesor = Asesor::find($asesorId);

        if (!$asesi || !$asesor) {
            throw new \Exception('Data asesi atau asesor tidak ditemukan');
        }

        // Get TUK information from rincian asesmen
        $tukName = 'LSP Politeknik Negeri Malang'; // Default
        if ($asesi->rincianAsesmen && $asesi->rincianAsesmen->event && $asesi->rincianAsesmen->event->tuk) {
            $tukName = $asesi->rincianAsesmen->event->tuk->nama_tuk;
        }

        // Check if IA11 already exists
        $existingIA11 = IA11::where('id_asesi', $asesiId)
                           ->where('id_asesor', $asesorId)
                           ->first();

        if ($existingIA11) {
            return $existingIA11;
        }

        return IA11::create([
            'id_asesi' => $asesiId,
            'id_asesor' => $asesorId,
            'id_skema' => $asesi->id_skema,
            'judul_sertifikasi' => $asesi->skema->nama_skema ?? '',
            'nama_peserta' => $asesi->nama_asesi ?? '',
            'nama_asesor' => $asesor->nama_asesor ?? '',
            'kegiatan_data' => null,
            'komentar_all' => null,
            'status' => 'draft',
        ]);
    }

    /**
     * Sign IA11 by asesor - matching IA02 functionality
     */
    public function signByAsesor(Request $request, $id)
    {
        try {
            // Handle both id as IA11 id or asesi id
            $ia11 = null;
            $asesorId = $request->header('X-Asesor-ID') ?: $request->input('asesor_id');
            
            if (!$asesorId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor ID tidak ditemukan'
                ], 400);
            }

            // Try to find IA11 by ID first, then by asesi ID
            $ia11 = IA11::find($id);
            if (!$ia11) {
                $ia11 = IA11::where('id_asesi', $id)
                           ->where('id_asesor', $asesorId)
                           ->first();
            }
            
            if (!$ia11) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA11 tidak ditemukan'
                ], 404);
            }

            // Get asesor data
            $asesor = Asesor::where('id_asesor', $asesorId)->first();
            
            if (!$asesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor tidak ditemukan'
                ], 404);
            }

            // Check if asesor has already signed this IA11
            if ($ia11->ttd_asesor && $ia11->waktu_tanda_tangan_asesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA11 sudah ditandatangani oleh asesor pada ' . $ia11->waktu_tanda_tangan_asesor
                ], 400);
            }

            // Check if asesor has valid signature file
            if (!$asesor->file_url_tanda_tangan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor belum memiliki tanda tangan digital. Silakan upload tanda tangan di biodata terlebih dahulu.'
                ], 400);
            }

            // Update IA11 with asesor signature and timestamp
            $signatureFile = basename($asesor->file_url_tanda_tangan);
            $now = Carbon::now();
            
            $ia11->ttd_asesor = $signatureFile;
            $ia11->waktu_tanda_tangan_asesor = $now;
            
            // Update status based on signature status
            if ($ia11->ttd_asesi) {
                // Both asesor and asesi have signed - mark as completed
                $ia11->status = 'completed';
            } else {
                // Only asesor has signed - mark as approved (waiting for asesi)
                $ia11->status = 'approved';
            }
            
            $ia11->save();

            // Update progress tracking
            $this->progressService->completeStep(
                $ia11->id_asesi,
                'ia11',
                'Completed by Asesor ID: ' . $asesorId . ' at ' . $now->format('d-m-Y H:i:s')
            );

            return response()->json([
                'status' => 'success',
                'message' => 'IA11 berhasil ditandatangani oleh asesor',
                'data' => [
                    'id' => $ia11->id,
                    'ttd_asesor' => $ia11->ttd_asesor,
                    'waktu_tanda_tangan_asesor' => $ia11->waktu_tanda_tangan_asesor->format('d-m-Y H:i:s') . ' WIB',
                    'status' => $ia11->status,
                    'is_completed' => $ia11->ttd_asesor && $ia11->ttd_asesi
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in signByAsesor IA11: ' . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menandatangani IA11: ' . $e->getMessage()
            ], 500);
        }
    }
}
