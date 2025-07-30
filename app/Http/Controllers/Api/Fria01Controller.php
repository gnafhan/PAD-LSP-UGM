<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fria01;
use App\Models\Asesi;
use App\Models\TandaTanganAsesor;
use App\Services\ProgressTrackingService;
use App\Services\AsesmenValidationService;
use Illuminate\Support\Facades\DB;

class Fria01Controller extends Controller
{
    protected $progressService;
    protected $validationService;

    public function __construct(ProgressTrackingService $progressService, AsesmenValidationService $validationService)
    {
        $this->progressService = $progressService;
        $this->validationService = $validationService;
    }

    /**
     * Asesi signs FRIA01 (set waktu_tanda_tangan_asesi if not set)
     */
    public function signAsesi(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'sometimes|string|exists:asesi,id_asesi',
        ]);

        $fria01 = Fria01::findOrFail($id);
        
        // Validate Asesi exists
        $asesiResult = $this->validationService->validateAsesiExists($fria01->id_asesi);
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }

        if ($fria01->isAsesiSigned()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sudah ditandatangani oleh asesi',
            ], 400);
        }

        $asesi = $fria01->asesi;
        if (!$asesi || !$asesi->ttd_pemohon) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tanda tangan asesi belum diupload',
            ], 400);
        }

        $fria01->waktu_tanda_tangan_asesi = now();
        $fria01->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil ditandatangani oleh asesi',
            'data' => [
                'waktu_tanda_tangan_asesi' => $fria01->waktu_tanda_tangan_asesi,
                'ttd_asesi' => $asesi->ttd_pemohon,
            ]
        ]);
    }

    /**
     * Asesor signs FRIA01 (set waktu_tanda_tangan_asesor if not set)
     */
    public function signAsesor(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
        ]);

        $fria01 = Fria01::findOrFail($id);
        
        // Validate Asesi exists
        $asesiResult = $this->validationService->validateAsesiExists($fria01->id_asesi);
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }

        // Validate Asesi-Asesor pair
        $pairResult = $this->validationService->validateAsesiAsesorPair(
            $fria01->id_asesi,
            $request->id_asesor
        );
        if ($pairResult) {
            return response()->json($pairResult, $pairResult['code']);
        }

        if ($fria01->isAsesorSigned()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sudah ditandatangani oleh asesor',
            ], 400);
        }

        $asesorId = $request->input('id_asesor') ?? $fria01->id_asesor;
        $ttdAsesor = TandaTanganAsesor::where('id_asesor', $asesorId)
            ->where(function($q){
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->orderByDesc('created_at')
            ->first();
        if (!$ttdAsesor || !$ttdAsesor->file_tanda_tangan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tanda tangan asesor belum diupload',
            ], 400);
        }

        $fria01->waktu_tanda_tangan_asesor = now();
        $fria01->save();

        $this->progressService->completeStep($fria01->id_asesi, 'ia01', 'Completed by Asesor ID: ' . $asesorId . ' at ' . now()->format('d-m-Y H:i:s'));

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil ditandatangani oleh asesor',
            'data' => [
                'waktu_tanda_tangan_asesor' => $fria01->waktu_tanda_tangan_asesor,
                'ttd_asesor' => $ttdAsesor->file_tanda_tangan,
            ]
        ]);
    }
}
