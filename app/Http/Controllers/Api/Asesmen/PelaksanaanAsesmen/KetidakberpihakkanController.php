<?php

namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesor;
use App\Models\Ketidakberpihakan;
use Carbon\Carbon;
use App\Services\AsesmenValidationService;
use App\Services\ProgressTrackingService;
use App\Helpers\DateTimeHelper;

/**
 * @OA\Tag(
 *     name="Ketidakberpihakan",
 *     description="API Endpoints untuk pengelolaan formulir Ketidakberpihakan (Pernyataan Ketidakberpihakan Asesor)"
 * )
 */
class KetidakberpihakkanController extends Controller
{
    protected $validationService;
    protected $progressService;

    
    public function __construct(AsesmenValidationService $validationService, ProgressTrackingService $progressService)
    {
        $this->validationService = $validationService;
        $this->progressService = $progressService;

    }

    /**
     * Get Ketidakberpihakan data for an Asesi
     * 
     * @OA\Get(
     *     path="/asesmen/ketidakberpihakan/{id_asesi}",
     *     summary="Mendapatkan data formulir Ketidakberpihakan untuk asesi",
     *     tags={"Ketidakberpihakan"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="id_asesi",
     *         in="path",
     *         required=true,
     *         description="ID asesi",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data formulir Ketidakberpihakan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="general_info",
     *                     type="object",
     *                     @OA\Property(property="nama_asesor", type="string", example="John Doe"),
     *                     @OA\Property(property="alamat", type="string", example="Jl. Contoh No. 123"),
     *                     @OA\Property(property="jabatan", type="string", example="Asesor"),
     *                     @OA\Property(property="kode_registrasi", type="string", example="REG-001")
     *                 ),
     *                 @OA\Property(
     *                     property="ketidakberpihakan",
     *                     type="object",
     *                     @OA\Property(property="waktu_tanda_tangan_asesor", type="string", format="date-time", example="2023-01-15T14:30:00"),
     *                     @OA\Property(property="tanda_tangan_asesor", type="string", example="storage/tanda_tangan/ttd_asesor.png")
     *                 ),
     *                 @OA\Property(property="record_exists", type="boolean", example=true)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Asesi tidak ditemukan atau belum memiliki rincian asesmen",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Asesi tidak ditemukan"),
     *             @OA\Property(property="code", type="integer", example=404)
     *         )
     *     )
     * )
     */
    public function getKetidakberpihakan(Request $request, $id_asesi)
    {
        // Validate Asesi exists
        $asesiResult = $this->validationService->validateAsesiExists(
            $id_asesi, 
            ['rincianAsesmen.asesor']
        );
        
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }
        
        $asesi = $asesiResult;
        
        // Validate Asesi has RincianAsesmen
        $rincianResult = $this->validationService->validateRincianAsesmen($asesi);
        if ($rincianResult) {
            return response()->json($rincianResult, $rincianResult['code']);
        }

        $asesor = $asesi->rincianAsesmen->asesor;
        $id_asesor = $asesor->id_asesor;
        
        // Get Ketidakberpihakan data if it exists
        $ketidakberpihakan = Ketidakberpihakan::where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->first();

        // Prepare general information
        $generalInfo = [
            'nama_asesor' => $asesor->nama_asesor,
            'alamat' => $asesor->alamat,
            'jabatan' => 'Asesor', // Hardcoded as requested
            'kode_registrasi' => $asesor->kode_registrasi
        ];

        // Check if the Ketidakberpihakan record exists
        if ($ketidakberpihakan && $ketidakberpihakan->waktu_tanda_tangan_asesor) {
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($ketidakberpihakan->waktu_tanda_tangan_asesor);
            $tandaTanganUrl = null;
            
            if ($tandaTanganAsesor) {
                $tandaTanganUrl = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }
            
            // Record exists - return the record data
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'ketidakberpihakan' => [
                        'waktu_tanda_tangan_asesor' =>DateTimeHelper::toWIB($ketidakberpihakan->waktu_tanda_tangan_asesor),
                        'tanda_tangan_asesor' => $tandaTanganUrl,
                    ],
                    'record_exists' => true
                ]
            ]);
        } else {
            // Record doesn't exist - provide only general information
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'record_exists' => false
                ]
            ]);
        }
    }

    /**
     * Sign Ketidakberpihakan form
     * 
     * @OA\Post(
     *     path="/asesmen/ketidakberpihakan/sign",
     *     summary="Menandatangani formulir Ketidakberpihakan oleh Asesor",
     *     tags={"Ketidakberpihakan"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formulir Ketidakberpihakan berhasil ditandatangani",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Formulir Ketidakberpihakan berhasil ditandatangani"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Asesi tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Asesi tidak ditemukan"),
     *             @OA\Property(property="code", type="integer", example=404)
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Asesor tidak ditugaskan untuk asesi ini",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Asesor tidak ditugaskan untuk asesi ini"),
     *             @OA\Property(property="code", type="integer", example=403)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function signKetidakberpihakan(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
        ]);

        // Validate Asesi exists
        $asesiResult = $this->validationService->validateAsesiExists($request->id_asesi);
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }
        
        // Validate Asesi-Asesor pair
        $pairResult = $this->validationService->validateAsesiAsesorPair(
            $request->id_asesi, 
            $request->id_asesor
        );
        if ($pairResult) {
            return response()->json($pairResult, $pairResult['code']);
        }

        // validate if assesor has tanda tangan
        $asesor = Asesor::find($request->id_asesor);
        if (!$asesor || !$asesor->tandaTanganAktif()->exists()) {
            return response()->json([
                'error' => true,
                'message' => 'Asesor tidak memiliki tanda tangan yang valid',
                'code' => 422
            ], 422);
        }

        // Find or create Ketidakberpihakan record
        $ketidakberpihakan = Ketidakberpihakan::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Set the signing timestamp
        $ketidakberpihakan->waktu_tanda_tangan_asesor = Carbon::now();
        
        // Save the record
        $ketidakberpihakan->save();
        
        // Update progress tracking if needed (like in other controllers)
        $this->progressService->completeStep(
            $request->id_asesi, 
            'pernyataan_ketidak_berpihakan', 
            'Completed by Asesor ID: ' . $request->id_asesor . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Formulir Ketidakberpihakan berhasil ditandatangani',
            'data' => $ketidakberpihakan
        ]);
    }
}