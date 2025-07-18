<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\IA02Service;
use App\Models\IA02;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class IA02Controller extends Controller
{
    protected $ia02Service;

    public function __construct(IA02Service $ia02Service)
    {
        $this->ia02Service = $ia02Service;
    }

    /**
     * Get IA02 data for specific asesi
     */
    public function getIA02ForAsesor(Request $request, $asesiId): JsonResponse
    {
        try {
            // Get asesor ID from header instead of auth
            $asesorId = $request->header('X-Asesor-ID');
            
            if (!$asesorId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor ID tidak ditemukan dalam header'
                ], 400);
            }

            $ia02 = $this->ia02Service->getIA02ForAsesi($asesiId, $asesorId);
            
            if (!$ia02) {
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
                        'nomor_sertifikasi' => $ia02->nomor_sertifikasi,
                        'nama_peserta' => $ia02->nama_peserta,
                        'nama_asesor' => $ia02->nama_asesor,
                        'tuk' => $ia02->tuk,
                        'instruksi_kerja' => $ia02->instruksi_kerja,
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
     * Sign IA02 by Asesor
     */
    public function signByAsesor(Request $request, $asesiId): JsonResponse
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

            $signatureData = $request->input('signature_data', null);
            
            $this->ia02Service->signByAsesor($ia02->id, $signatureData);

            return response()->json([
                'status' => 'success',
                'message' => 'IA02 berhasil ditandatangani oleh asesor'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menandatangani IA02: ' . $e->getMessage()
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
                        'nomor_skema' => $ia02->skema->kode_skema ?? 'N/A',
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
}
