<?php

namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DateTimeHelper;
use App\Models\Fria05;
use App\Models\Soal;
use Carbon\Carbon;
use App\Services\AsesmenValidationService;
use App\Models\TandaTanganAsesor;
use App\Services\ProgressTrackingService;
use Illuminate\Support\Facades\Log;



/**
 * @OA\Tag(
 *     name="FRIA05",
 *     description="API Endpoints untuk pengelolaan formulir FRIA05 (Persetujuan Asesmen & Kerahasiaan)"
 * )
 */
class Fria05Controller extends Controller
{
    protected $validationService;
    protected $progressService;


    public function __construct(AsesmenValidationService $validationService, ProgressTrackingService $progressService)
    {
        $this->validationService = $validationService;
        $this->progressService = $progressService;

    }

    /**
     * Get FRIA05 data for an Asesi
     *
     * @OA\Get(
     *     path="/asesmen/fria05/{id_asesi}",
     *     summary="Mendapatkan data formulir FRIA05 untuk asesi",
     *     tags={"FRIA05"},
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
     *         description="Data formulir FRIA05",
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
     *                     property="fria05",
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
    public function getFria05(Request $request, $id_asesi)
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

        // Get FRIA05 data if it exists
        $fria05 = Fria05::where('id_asesi', $id_asesi)
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

        $skema = $asesi->skema;
        // $detailSkema = [];
        
        // if ($skema) {
        //     foreach ($skema->unitKompetensi as $uk) {
        //         $unitData = [
        //             'id_uk' => $uk->id_uk,
        //             'kode_uk' => $uk->kode_uk,
        //             'nama_uk' => $uk->nama_uk,
        //             'elemen_uk' => []
        //         ];
                
        //         foreach ($uk->elemen_uk as $elemen) {
        //             $unitData['elemen_uk'][] = [
        //                 'nama_elemen' => $elemen->nama_elemen,
        //                 'kompeten' => null // Null because not yet assessed
        //             ];
        //         }
                
        //         $detailSkema[] = $unitData;
        //     }
        // }
        
        // get soal
        $soals = Soal::where('id_skema', $skema->id_skema)->get();

        // Check if the FRIA05 record exists
        if ($fria05) {
            // Check if the asesor has a valid signature
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($fria05->waktu_tanda_tangan_asesor);
            if ($tandaTanganAsesor) {
                $tandaTanganAsesor->file_url = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }


            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    // 'detail_skema' => $detailSkema,
                    'list_soal' => $soals,
                    'fria05' => [
                        'list_jawaban' => $fria05->jawabans,
                        'waktu_tanda_tangan_asesi' => DateTimeHelper::toWIB($fria05->waktu_tanda_tangan_asesi),
                        'tanda_tangan_asesi' => $fria05->waktu_tanda_tangan_asesi ? $asesi->ttd_pemohon = asset('storage/' . $asesi->ttd_pemohon) : null,
                        'waktu_tanda_tangan_asesor' => DateTimeHelper::toWIB($fria05->waktu_tanda_tangan_asesor),
                        'tanda_tangan_asesor' => $tandaTanganAsesor ? $tandaTanganAsesor->file_url : null,
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
                    'list_soal' => $soals,
                    'record_exists' => false
                ]
            ]);
        }
    }

    /**
     * Create or update FRIA05 data for Asesi
     *
     * @OA\Post(
     *     path="/asesmen/fria05/asesi/save",
     *     summary="Menyimpan tanda tangan Asesi pada formulir FRIA05",
     *     tags={"FRIA05"},
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
     *         description="Data FRIA05 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data FRIA05 berhasil ditandatangani oleh Asesi"),
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
    public function saveFria05Asesi(Request $request)
    {
        // // Validate the request
        // $request->validate([
        //     'id_asesi' => 'required|string|exists:asesi,id_asesi',
        //     'id_asesor' => 'required|string|exists:asesor,id_asesor',
        //     'is_signing' => 'required|boolean'
        // ]);

        // // Validate Asesi exists
        // $asesiResult = $this->validationService->validateAsesiExists($request->id_asesi);
        // if (isset($asesiResult['error'])) {
        //     return response()->json($asesiResult, $asesiResult['code']);
        // }

        // // Validate Asesi-Asesor pair
        // $pairResult = $this->validationService->validateAsesiAsesorPair(
        //     $request->id_asesi,
        //     $request->id_asesor
        // );
        // if ($pairResult) {
        //     return response()->json($pairResult, $pairResult['code']);
        // }

        // // Find or create FRIA05 record
        // $fria05 = Fria05::firstOrNew([
        //     'id_asesi' => $request->id_asesi,
        //     'id_asesor' => $request->id_asesor,
        // ]);

        // // Set the signing timestamp if the asesi is signing
        // if ($request->boolean('is_signing')) {
        //     $fria05->waktu_tanda_tangan_asesi = now();
        // }

        // $fria05->save();

        // // Check if both asesi and asesor have signed, and if so, update progress
        // if ($fria05->waktu_tanda_tangan_asesi && $fria05->waktu_tanda_tangan_asesor) {
        //     // Update the progres_asesmen table
        //     log::info('FRIA05 completed by Asesi', [
        //         'id_asesi' => $request->id_asesi,
        //         'id_asesor' => $request->id_asesor,
        //         'timestamp' => Carbon::now()->format('d-m-Y H:i:s')
        //     ]);
        //     $this->progressService->completeStep(
        //         $request->id_asesi,
        //         'fria05',
        //         'Completed by Asesi ID: ' . $request->id_asesi . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
        //     );
        // }

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data FRIA05 berhasil ditandatangani oleh Asesi',
        //     'data' => $fria05
        // ]);
    }

    /**
     * Create or update FRIA05 data for Asesor
     *
     * @OA\Post(
     *     path="/asesmen/fria05/asesor/save",
     *     summary="Menyimpan data formulir FRIA05 oleh Asesor",
     *     tags={"FRIA05"},
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
     *         description="Data FRIA05 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data FRIA05 berhasil disimpan oleh Asesor"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function saveFria05Asesor(Request $request)
    {
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'list_jawaban' => 'required|array|min:1',
            'list_jawaban.*.kode_soal' => 'required|string',
            'list_jawaban.*.jawaban' => 'required|string',
            'is_signing' => 'sometimes|boolean',
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

        // Find or create FRIA05 record
        $fria05 = Fria05::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Update asesor's signature timestamp if signing
        if ($request->boolean('is_signing')) {
            $tanda_tangan_asesor = TandaTanganAsesor::where('id_asesor', $request->id_asesor)->first();
            if ($tanda_tangan_asesor) {
                $fria05->waktu_tanda_tangan_asesor = now();
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor tidak memiliki tanda tangan',
                ], 422);
            }
        }

        $fria05->save();

        // Remove old answers
        $fria05->jawabans()->delete();

        // Save all answers from list_jawaban
        foreach ($request->list_jawaban as $jawaban) {
            $fria05->jawabans()->create([
                'kode_soal' => $jawaban['kode_soal'],
                'jawaban' => $jawaban['jawaban'],
            ]);
        }

        // Mark step complete if both signed
        if ($fria05->waktu_tanda_tangan_asesi && $fria05->waktu_tanda_tangan_asesor) {
            $this->progressService->completeStep(
                $request->id_asesi,
                'fria05',
                'Completed by Asesor ID: ' . $request->id_asesor . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
            );
            Log::info('FRIA05 completed by Asesor', [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
                'timestamp' => Carbon::now()->format('d-m-Y H:i:s')
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data FRIA05 berhasil disimpan oleh Asesor',
            'data' => $fria05->load('jawabans')
        ]);
    }

}
