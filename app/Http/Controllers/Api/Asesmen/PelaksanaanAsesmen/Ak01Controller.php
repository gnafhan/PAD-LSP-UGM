<?php

namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DateTimeHelper;
use App\Models\Ak01;
use Carbon\Carbon;
use App\Services\AsesmenValidationService;
use App\Models\TandaTanganAsesor;
use App\Services\ProgressTrackingService;
use Illuminate\Support\Facades\Log;



/**
 * @OA\Tag(
 *     name="AK01",
 *     description="API Endpoints untuk pengelolaan formulir AK01 (Persetujuan Asesmen & Kerahasiaan)"
 * )
 */
class Ak01Controller extends Controller
{
    protected $validationService;
    protected $progressService;

    
    public function __construct(AsesmenValidationService $validationService, ProgressTrackingService $progressService)
    {
        $this->validationService = $validationService;
        $this->progressService = $progressService;

    }

    /**
     * Get AK01 data for an Asesi
     * 
     * @OA\Get(
     *     path="/asesmen/ak01/{id_asesi}",
     *     summary="Mendapatkan data formulir AK01 untuk asesi",
     *     tags={"AK01"},
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
     *         description="Data formulir AK01",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="general_info",
     *                     type="object",
     *                     @OA\Property(property="nama_asesi", type="string", example="John Doe"),
     *                     @OA\Property(property="nama_asesor", type="string", example="Jane Smith"),
     *                     @OA\Property(property="nama_tuk", type="string", example="TUK JTTC"),
     *                     @OA\Property(property="judul_skema", type="string", example="Programmer"),
     *                     @OA\Property(property="kode_skema", type="string", example="SKM-001"),
     *                     @OA\Property(property="pelaksanaan_asesmen_disepakati_mulai", type="string", format="date", example="2025-01-15")
     *                 ),
     *                 @OA\Property(
     *                     property="ak01",
     *                     type="object",
     *                     @OA\Property(property="hasil_yang_akan_dikumpulkan", type="string", example="Hasil unjuk kerja, portofolio, dan knowledge test"),
     *                     @OA\Property(property="waktu_tanda_tangan_asesi", type="string", format="date", example="2025-05-14", nullable=true),
     *                     @OA\Property(property="waktu_tanda_tangan_asesor", type="string", format="date", example="2025-05-15", nullable=true),
     *                     @OA\Property(property="tanda_tangan_asesor", type="string", format="string", example="tanda_tangan/ttd_asesor.png"),
     *                     @OA\Property(property="tanda_tangan_asesi", type="string", format="string", example="signature/ttd_asesi.png"),
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
    public function getAk01(Request $request, $id_asesi)
    {
        // Validate Asesi exists
        $asesiResult = $this->validationService->validateAsesiExists(
            $id_asesi, 
            ['skema', 'rincianAsesmen.asesor', 'rincianAsesmen.event.tuk']
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
        
        // Get AK01 data if it exists
        $ak01 = Ak01::where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->first();

        // Prepare general information
        $generalInfo = [
            'nama_asesi' => $asesi->nama_asesi,
            'nama_asesor' => $asesor->nama_asesor,
            'nama_tuk' => $asesi->rincianAsesmen->event->tuk->nama_tuk,
            'judul_skema' => $asesi->skema->nama_skema,
            'kode_skema' => $asesi->skema->nomor_skema,
            'pelaksanaan_asesmen_disepakati_mulai' => $asesi->created_at->format('d-m-Y')
        ];

        // Check if the AK01 record exists
        if ($ak01) {
            // Check if the asesor has a valid signature
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($ak01->waktu_tanda_tangan_asesor);
            if ($tandaTanganAsesor) {
                $tandaTanganAsesor->file_url = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }

            // Retrieve hasil items
            $hasilItems = $ak01->hasilItems()->pluck('hasil_item')->toArray();

            // Record exists - return the record data
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'ak01' => [
                        'hasil_yang_akan_dikumpulkan' => $hasilItems,
                        'waktu_tanda_tangan_asesi' => DateTimeHelper::toWIB($ak01->waktu_tanda_tangan_asesi),                        
                        'tanda_tangan_asesi' => $asesi->ttd_pemohon ? $asesi->ttd_pemohon = asset('storage/' . $asesi->ttd_pemohon) : null,
                        'waktu_tanda_tangan_asesor' => DateTimeHelper::toWIB($ak01->waktu_tanda_tangan_asesor),                        
                        'tanda_tangan_asesor' => $tandaTanganAsesor ? $tandaTanganAsesor->file_url : "null",
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
     * Create or update AK01 data for Asesi
     * 
     * @OA\Post(
     *     path="/asesmen/ak01/asesi/save",
     *     summary="Menyimpan tanda tangan Asesi pada formulir AK01",
     *     tags={"AK01"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *             @OA\Property(property="is_signing", type="boolean", example=true, description="Set to true to sign the form")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data AK01 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data AK01 berhasil ditandatangani oleh Asesi"),
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
     *         description="Asesi tidak terdaftar dengan asesor ini",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Asesi tidak terdaftar dengan asesor ini"),
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
    public function saveAk01Asesi(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'is_signing' => 'required|boolean'
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

        // Find or create AK01 record
        $ak01 = Ak01::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Set the signing timestamp if the asesi is signing
        if ($request->boolean('is_signing')) {
            $ak01->waktu_tanda_tangan_asesi = now();
        }

        $ak01->save();

        // Check if both asesi and asesor have signed, and if so, update progress
        if ($ak01->waktu_tanda_tangan_asesi && $ak01->waktu_tanda_tangan_asesor) {
            // Update the progres_asesmen table
            log::info('AK01 completed by Asesi', [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
                'timestamp' => Carbon::now()->format('d-m-Y H:i:s')
            ]);
            $this->progressService->completeStep(
                $request->id_asesi, 
                'ak01', 
                'Completed by Asesi ID: ' . $request->id_asesi . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data AK01 berhasil ditandatangani oleh Asesi',
            'data' => $ak01
        ]);
    }

    /**
     * Create or update AK01 data for Asesor
     * 
     * @OA\Post(
     *     path="/asesmen/ak01/asesor/save",
     *     summary="Menyimpan data formulir AK01 oleh Asesor",
     *     tags={"AK01"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor", "hasil_yang_akan_dikumpulkan"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *             @OA\Property(property="hasil_yang_akan_dikumpulkan", type="array", 
     *                @OA\Items(type="string", example="Hasil Observasi Langsung")),
     *             @OA\Property(property="is_signing", type="boolean", example=true, description="Set to true if the asesor is signing the form")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data AK01 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data AK01 berhasil disimpan oleh Asesor"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function saveAk01Asesor(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'hasil_yang_akan_dikumpulkan' => 'required|array|min:1',
            'hasil_yang_akan_dikumpulkan.*' => 'required|string',
            'is_signing' => 'sometimes|boolean'
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

        // Find or create AK01 record
        $ak01 = Ak01::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Update asesor's signature timestamp if signing
        if ($request->boolean('is_signing')) {
            // check if asesor has a signature
            $tanda_tangan_asesor = TandaTanganAsesor::where('id_asesor', $request->id_asesor)->first();
            if ($tanda_tangan_asesor) {
                $ak01->waktu_tanda_tangan_asesor = now();                
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor tidak memiliki tanda tangan',
                ], 422);
            }
        }

        $ak01->save();

        // Delete any existing hasil items to avoid duplicates
        if ($ak01->id) {
            $ak01->hasilItems()->delete();
        }

        // Add the new hasil items
        foreach ($request->hasil_yang_akan_dikumpulkan as $hasilItem) {
            $ak01->hasilItems()->create([
                'hasil_item' => $hasilItem
            ]);
        }

        // Check if both asesi and asesor have signed, and if so, update progress
        if ($ak01->waktu_tanda_tangan_asesi && $ak01->waktu_tanda_tangan_asesor) {
            // Update the progres_asesmen table
            $this->progressService->completeStep(
                $request->id_asesi, 
                'ak01', 
                'Completed by Asesor ID: ' . $request->id_asesor . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
            );
            log::info('AK01 completed by Asesor', [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
                'timestamp' => Carbon::now()->format('d-m-Y H:i:s')
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data AK01 berhasil disimpan oleh Asesor',
            'data' => $ak01->load('hasilItems')
        ]);
    }
}