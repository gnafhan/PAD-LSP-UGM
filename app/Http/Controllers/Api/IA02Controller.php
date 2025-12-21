<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\IA02Service;
use App\Services\ProgressTrackingService;
use App\Models\IA02;
use App\Models\Asesor;
use App\Models\RincianAsesmen;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IA02Controller extends Controller
{
    protected $ia02Service;
    protected $progressService;

    public function __construct(IA02Service $ia02Service, ProgressTrackingService $progressService)
    {
        $this->ia02Service = $ia02Service;
        $this->progressService = $progressService;
    }

    /**
     * Get IA02 data for specific asesi
     */
    public function getIA02ForAsesor(Request $request, $asesiId): JsonResponse
    {
        try {
            // Get asesor ID from header instead of auth
            $asesorId = $request->header('X-Asesor-ID');
            
            // Debug logging
            Log::info('IA02 API called', [
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

            $ia02 = $this->ia02Service->getIA02ForAsesi($asesiId, $asesorId);
            
            Log::info('IA02 Service result', [
                'ia02_found' => !!$ia02,
                'ia02_id' => $ia02 ? $ia02->id : null
            ]);
            
            if (!$ia02) {
                // Try to find any IA02 for this asesi without asesor filter for debugging
                $anyIA02 = IA02::where('id_asesi', $asesiId)->first();
                Log::info('Debug: Any IA02 for this asesi?', [
                    'any_ia02_found' => !!$anyIA02,
                    'any_ia02_asesor' => $anyIA02 ? $anyIA02->id_asesor : null
                ]);
                
                // Create new IA02 if not exists
                $ia02 = $this->ia02Service->createIA02ForAsesi($asesiId, $asesorId);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'record_exists' => true,
                    'detail_ia02' => [
                        'id' => $ia02->id,
                        'id_asesi' => $ia02->id_asesi,
                        'id_asesor' => $ia02->id_asesor,
                        'id_skema' => $ia02->id_skema,
                        'judul_sertifikasi' => $ia02->judul_sertifikasi,
                        'nomor_skema' => $ia02->nomor_skema, // Using accessor
                        'nama_skema' => $ia02->skema->nama_skema ?? 'N/A',
                        'nama_peserta' => $ia02->nama_peserta,
                        'nama_asesor' => $ia02->nama_asesor,
                        'tuk' => $ia02->tuk, // Using accessor
                        'instruksi_kerja' => $ia02->instruksi_kerja,
                        'has_scheme_template' => $this->ia02Service->hasTemplateForSkema($ia02->id_skema), // Requirements: 8.4
                        'waktu_tanda_tangan_asesor' => $ia02->waktu_tanda_tangan_asesor?->format('d-m-Y H:i:s') . ' WIB',
                        'waktu_tanda_tangan_asesi' => $ia02->waktu_tanda_tangan_asesi?->format('d-m-Y H:i:s') . ' WIB',
                        'ttd_asesor' => $ia02->ttd_asesor,
                        'ttd_asesi' => $ia02->ttd_asesi,
                        'status' => $ia02->status,
                        'status_label' => $ia02->status_label,
                        'is_asesor_signed' => $ia02->isAsesorSigned(),
                        'is_asesi_signed' => $ia02->isAsesiSigned(),
                        'is_completed' => $ia02->isCompleted(),
                        'catatan' => $ia02->catatan,
                    ],
                    'kompetensis' => $ia02->kompetensis->map(function ($kompetensi) {
                        return [
                            'id' => $kompetensi->id,
                            'id_uk' => $kompetensi->id_uk,
                            'kode_uk' => $kompetensi->kode_uk,
                            'nama_uk' => $kompetensi->nama_uk,
                            'deskripsi_kompetensi' => $kompetensi->deskripsi_kompetensi,
                            'urutan' => $kompetensi->urutan,
                        ];
                    }),
                    'proses_assessments' => $ia02->prosesAssessments->map(function ($proses) {
                        return [
                            'id' => $proses->id,
                            'nomor_proses' => $proses->nomor_proses,
                            'judul_proses' => $proses->judul_proses,
                            'deskripsi_proses' => $proses->deskripsi_proses,
                            'instruksi_kerjas' => $proses->instruksiKerjas->map(function ($instruksi) {
                                return [
                                    'id' => $instruksi->id,
                                    'nomor_urut' => $instruksi->nomor_urut,
                                    'instruksi_kerja' => $instruksi->instruksi_kerja,
                                    'standar_alat_media' => $instruksi->standar_alat_media,
                                    'output_yang_diharapkan' => $instruksi->output_yang_diharapkan,
                                ];
                            })
                        ];
                    })
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data IA02: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update IA02 data
     */
    public function updateIA02(Request $request, $asesiId): JsonResponse
    {
        try {
            // Get asesor ID from header
            $asesorId = $request->header('X-Asesor-ID');
            
            if (!$asesorId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor ID tidak ditemukan dalam header'
                ], 400);
            }

            $ia02 = $this->ia02Service->getIA02ForAsesi($asesiId, $asesorId);
            
            if (!$ia02) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data IA02 tidak ditemukan'
                ], 404);
            }

            $validated = $request->validate([
                'instruksi_kerja' => 'sometimes|string',
                'catatan' => 'sometimes|string|nullable',
                'status' => 'sometimes|in:draft,submitted,approved,completed'
            ]);

            $this->ia02Service->updateIA02($ia02->id, $validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Data IA02 berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui data IA02: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sign IA02 by asesor menggunakan signature dari database
     */
    public function signByAsesor(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'asesor_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $ia02 = IA02::find($id);
            
            if (!$ia02) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA02 tidak ditemukan'
                ], 404);
            }

            // Get asesor data
            $asesor = Asesor::where('id_asesor', $request->asesor_id)->first();
            
            if (!$asesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor tidak ditemukan'
                ], 404);
            }

            // Check if asesor has already signed this IA02
            if ($ia02->ttd_asesor && $ia02->waktu_tanda_tangan_asesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA02 sudah ditandatangani oleh asesor pada ' . $ia02->waktu_tanda_tangan_asesor
                ], 400);
            }

            // Check if IA02 is in correct status for signing
            if (!in_array($ia02->status, ['draft', 'submitted'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA02 tidak dapat ditandatangani. Status saat ini: ' . $ia02->status
                ], 400);
            }

            // Check if asesor has valid signature in tanda_tangan_asesor table
            $tandaTanganAsesor = DB::table('tanda_tangan_asesor')
                ->where('id_asesor', $request->asesor_id)
                ->where(function ($query) {
                    $query->whereNull('valid_until')
                          ->orWhere('valid_until', '>=', now());
                })
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$tandaTanganAsesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor belum memiliki tanda tangan digital yang valid. Silakan upload tanda tangan terlebih dahulu.'
                ], 400);
            }

            // Update IA02 with asesor signature and timestamp
            $now = Carbon::now()->format('d-m-Y H:i:s') . ' WIB';
            
            $ia02->ttd_asesor = $tandaTanganAsesor->file_tanda_tangan;
            $ia02->waktu_tanda_tangan_asesor = $now;
            
            // Update status based on signature status
            if ($ia02->ttd_asesi) {
                // Both asesor and asesi have signed - mark as completed
                $ia02->status = 'completed';
            } else {
                // Only asesor has signed - mark as approved (waiting for asesi)
                $ia02->status = 'approved';
            }
            
            $ia02->save();

            return response()->json([
                'status' => 'success',
                'message' => 'IA02 berhasil ditandatangani oleh asesor',
                'data' => [
                    'signature_data' => [
                        'ttd_asesor' => $ia02->ttd_asesor,
                        'waktu_tanda_tangan' => $ia02->waktu_tanda_tangan_asesor,
                        'nama_asesor' => $asesor->nama_asesor,
                        'status' => $ia02->status,
                        'status_message' => $ia02->status === 'approved' ? 'Menunggu tanda tangan asesi' : 'IA02 telah selesai'
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    // sign by asesi
    public function signByAsesi(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'is_signing' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $ia02 = IA02::find($id);
            if (!$ia02) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA02 tidak ditemukan'
                ], 404);
            }

            // Get asesi
            $asesi = $ia02->asesi;
            if (!$asesi) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data asesi tidak ditemukan'
                ], 404);
            }

            // Ensure asesor has signed first
            if (!$ia02->waktu_tanda_tangan_asesor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA02 belum ditandatangani oleh asesor'
                ], 422);
            }

            // Check if asesi has a signature file
            if ($request->is_signing && empty($asesi->ttd_pemohon)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesi belum memiliki tanda tangan',
                ], 422);
            }

            // Set signature timestamp and file if signing
            if ($request->is_signing) {
                $ia02->waktu_tanda_tangan_asesi = Carbon::now();
                $ia02->ttd_asesi = $asesi->ttd_pemohon;
                $ia02->save();
            }

            // Optionally, update status if both signatures present
            if ($ia02->waktu_tanda_tangan_asesi && $ia02->waktu_tanda_tangan_asesor) {
                $ia02->status = 'completed';
                $ia02->save();
                // Update progress tracking (mirroring APL02Controller)
                $this->progressService->completeStep(
                    $ia02->id_asesi,
                    'ia02',
                    'Completed by Asesi ID: ' . $ia02->id_asesi . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
                );
            }

            return response()->json([
                'status' => 'success',
                'message' => 'IA02 berhasil ditandatangani oleh Asesi',
                'data' => [
                    'id' => $ia02->id,
                    'waktu_tanda_tangan_asesi' => $ia02->waktu_tanda_tangan_asesi,
                    'ttd_asesi' => $ia02->ttd_asesi,
                    'waktu_tanda_tangan_asesor' => $ia02->waktu_tanda_tangan_asesor,
                    'ttd_asesor' => $ia02->ttd_asesor,
                    'status' => $ia02->status,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all IA02 for asesor dashboard
     */
    public function getIA02ListForAsesor(Request $request): JsonResponse
    {
        try {
            // Get asesor ID from header
            $asesorId = $request->header('X-Asesor-ID');
            
            if (!$asesorId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor ID tidak ditemukan dalam header'
                ], 400);
            }

            $ia02List = IA02::with(['asesi', 'skema'])
                ->where('id_asesor', $asesorId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($ia02) {
                    return [
                        'id' => $ia02->id,
                        'id_asesi' => $ia02->id_asesi,
                        'nama_asesi' => $ia02->asesi->nama_asesi ?? 'N/A',
                        'nama_skema' => $ia02->skema->nama_skema ?? 'N/A',
                        'nomor_skema' => $ia02->skema->nomor_skema ?? 'N/A',
                        'status' => $ia02->status,
                        'status_label' => $ia02->status_label,
                        'is_completed' => $ia02->isCompleted(),
                        'created_at' => $ia02->created_at->format('d-m-Y H:i:s') . ' WIB',
                        'updated_at' => $ia02->updated_at->format('d-m-Y H:i:s') . ' WIB',
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'ia02_list' => $ia02List,
                    'total' => $ia02List->count()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil daftar IA02: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update instruksi kerja pada IA02
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInstruksiKerja(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'instruksi_kerja' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 400);
            }

            $ia02 = IA02::find($id);
            
            if (!$ia02) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA02 tidak ditemukan'
                ], 404);
            }

            // Update instruksi kerja
            $ia02->instruksi_kerja = $request->instruksi_kerja;
            $ia02->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Instruksi kerja berhasil disimpan',
                'data' => [
                    'id' => $ia02->id,
                    'instruksi_kerja' => $ia02->instruksi_kerja
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Get IA02 detail including instruksi_kerja
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetail($id)
    {
        try {
            $ia02 = IA02::with(['asesi', 'asesor'])->find($id);
            
            if (!$ia02) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'IA02 tidak ditemukan'
                ], 404);
            }

            // Debug logging for instruksi_kerja
            Log::info('IA02 getDetail debug', [
                'ia02_id' => $ia02->id,
                'instruksi_kerja_value' => $ia02->instruksi_kerja,
                'instruksi_kerja_type' => gettype($ia02->instruksi_kerja),
                'instruksi_kerja_length' => $ia02->instruksi_kerja ? strlen($ia02->instruksi_kerja) : 0,
                'instruksi_kerja_preview' => $ia02->instruksi_kerja ? substr($ia02->instruksi_kerja, 0, 100) : null
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data IA02 berhasil diambil',
                'data' => [
                    'detail_ia02' => $ia02,
                    'debug_instruksi_kerja' => [
                        'value' => $ia02->instruksi_kerja,
                        'type' => gettype($ia02->instruksi_kerja),
                        'length' => $ia02->instruksi_kerja ? strlen($ia02->instruksi_kerja) : 0,
                        'preview' => $ia02->instruksi_kerja ? substr($ia02->instruksi_kerja, 0, 100) : null,
                        'is_null' => is_null($ia02->instruksi_kerja),
                        'is_empty' => empty($ia02->instruksi_kerja)
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function generatePdf($id_asesi)
{
    $detailRincian = RincianAsesmen::with([
        'asesi.skema',
        'asesi.progresAsesmen',
        'asesor',
        'event.tuk',
    ])->where('id_asesi', $id_asesi)->first();
    
    if (!$detailRincian) {
        return redirect()->route('fria02-asesor')->with('error', 'Data asesi tidak ditemukan');
    }
    
    if ($detailRincian->asesi && $detailRincian->asesi->skema) {
        $idArray = is_array($detailRincian->asesi->skema->daftar_id_uk) 
            ? $detailRincian->asesi->skema->daftar_id_uk 
            : json_decode($detailRincian->asesi->skema->daftar_id_uk, true);
        
        $detailRincian->asesi->skema->unitKompetensiLoaded = \App\Models\UK::with('elemen_uk')
            ->whereIn('id_uk', $idArray ?? [])
            ->get();
    }
    
    // Fetch IA02
    $formData = IA02::with(['prosesAssessments.instruksiKerjas'])
        ->where('id_asesi', $id_asesi)
        ->where('id_asesor', $detailRincian->id_asesor)
        ->where('id_skema', $detailRincian->asesi->id_skema)
        ->first();
        
    return view('home.home-asesor.fria02-pdf', compact('detailRincian', 'formData'));
}

}
