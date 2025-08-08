<?php

namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use App\Models\Ak07SeederA;
use App\Models\Ak07SeederB;
use App\Models\PotensiAsesi;
use Illuminate\Http\Request;
use App\Helpers\DateTimeHelper;
use App\Models\Ak07;
use Carbon\Carbon;
use App\Services\AsesmenValidationService;
use App\Models\TandaTanganAsesor;
use App\Services\ProgressTrackingService;
use Illuminate\Support\Facades\Log;


/**
 * @OA\Tag(
 *     name="AK07",
 *     description="API Endpoints untuk pengelolaan formulir AK07 (Persetujuan Asesmen & Kerahasiaan)"
 * )
 */
class Ak07Controller extends Controller
{
    protected $validationService;
    protected $progressService;


    public function __construct(AsesmenValidationService $validationService, ProgressTrackingService $progressService)
    {
        $this->validationService = $validationService;
        $this->progressService = $progressService;

    }

    /**
     * Get AK07 data for an Asesi
     *
     * @OA\Get(
     *     path="/asesmen/ak07/{id_asesi}",
     *     summary="Mendapatkan data formulir AK07 untuk asesi",
     *     tags={"AK07"},
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
     *         description="Data formulir AK07",
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
     *                     property="ak07",
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
    public function getAk07(Request $request, $id_asesi)
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

        // Get AK07 data if it exists
        $ak07 = Ak07::where('id_asesi', $id_asesi)
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

        // seeder a dan b + potensi
        $seederA = Ak07SeederA::all();
        $seederB = Ak07SeederB::all();
        $potensiAsesi = PotensiAsesi::all();

        // Check if the AK07 record exists
        if ($ak07) {
            // Check if the asesor has a valid signature
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($ak07->waktu_tanda_tangan_asesor);
            if ($tandaTanganAsesor) {
                $tandaTanganAsesor->file_url = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }

            // Retrieve hasil items
            $hasilItems = $ak07->hasilItems()->pluck('hasil_item')->toArray();

            // Record exists - return the record data
            $bagianA = $ak07->bagianAs()->get(['item', 'penyesuaian']);
            $bagianB = $ak07->bagianBs()->get(['item', 'penyesuaian', 'lainnya']);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'seeder_a' => $seederA,
                    'seeder_b' => $seederB,
                    'potensi_asesi' => $potensiAsesi,
                    'ak07' => [
                        'hasil_yang_akan_dikumpulkan' => $hasilItems,
                        'bagian_a' => $bagianA,
                        'bagian_b' => $bagianB,
                        'waktu_tanda_tangan_asesi' => DateTimeHelper::toWIB($ak07->waktu_tanda_tangan_asesi),
                        'tanda_tangan_asesi' => $ak07->waktu_tanda_tangan_asesi ? $asesi->ttd_pemohon = asset('storage/' . $asesi->ttd_pemohon) : null,
                        'waktu_tanda_tangan_asesor' => DateTimeHelper::toWIB($ak07->waktu_tanda_tangan_asesor),
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
                    'potensi_asesi' => $potensiAsesi,
                    'seeder_a' => $seederA,
                    'seeder_b' => $seederB,
                    'general_info' => $generalInfo,
                    'record_exists' => false
                ]
            ]);
        }
    }

    /**
     * Create or update AK07 data for Asesi
     *
     * @OA\Post(
     *     path="/asesmen/ak07/asesi/save",
     *     summary="Menyimpan tanda tangan Asesi pada formulir AK07",
     *     tags={"AK07"},
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
     *         description="Data AK07 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data AK07 berhasil ditandatangani oleh Asesi"),
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
    public function saveAk07Asesi(Request $request)
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

        // Find or create AK07 record
        $ak07 = Ak07::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Set the signing timestamp if the asesi is signing
        if ($request->boolean('is_signing')) {
            $ak07->waktu_tanda_tangan_asesi = now();
        }

        $ak07->save();

        // Check if both asesi and asesor have signed, and if so, update progress
        if ($ak07->waktu_tanda_tangan_asesi && $ak07->waktu_tanda_tangan_asesor) {
            // Update the progres_asesmen table
            log::info('AK07 completed by Asesi', [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
                'timestamp' => Carbon::now()->format('d-m-Y H:i:s')
            ]);
            $this->progressService->completeStep(
                $request->id_asesi,
                'ak07',
                'Completed by Asesi ID: ' . $request->id_asesi . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data AK07 berhasil ditandatangani oleh Asesi',
            'data' => $ak07
        ]);
    }

    /**
     * Create or update AK07 data for Asesor
     *
     * @OA\Post(
     *     path="/asesmen/ak07/asesor/save",
     *     summary="Menyimpan data formulir AK07 oleh Asesor",
     *     tags={"AK07"},
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
     *         description="Data AK07 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data AK07 berhasil disimpan oleh Asesor"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function saveAk07Asesor(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'hasil_yang_akan_dikumpulkan' => 'required|array|min:1',
            'hasil_yang_akan_dikumpulkan.*' => 'required|string',
            'is_signing' => 'sometimes|boolean',
            'bagian_a' => 'sometimes|array',
            'bagian_a.*.item' => 'nullable|string',
            // 'bagian_a.*.penyesuaian' => 'nullable|in:true,false,1,0',

            'bagian_b' => 'sometimes|array',
            'bagian_b.*.item' => 'nullable|string',
            // 'bagian_b.*.penyesuaian' => 'nullable|in:true,false,1,0',
            'bagian_b.*.lainnya' => 'nullable|string'

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

        // Find or create AK07 record
        $ak07 = Ak07::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Update asesor's signature timestamp if signing
        if ($request->boolean('is_signing')) {
            // check if asesor has a signature
            $tanda_tangan_asesor = TandaTanganAsesor::where('id_asesor', $request->id_asesor)->first();
            if ($tanda_tangan_asesor) {
                $ak07->waktu_tanda_tangan_asesor = now();
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor tidak memiliki tanda tangan',
                ], 422);
            }
        }

        $ak07->save();

        // Delete any existing hasil items to avoid duplicates
        if ($ak07->id) {
            $ak07->hasilItems()->delete();
        }

        // Add the new hasil items
        foreach ($request->hasil_yang_akan_dikumpulkan as $hasilItem) {
            $ak07->hasilItems()->create([
                'hasil_item' => $hasilItem
            ]);
        }

        // Clear existing Bagian A and B
        $ak07->bagianAs()->delete();
        $ak07->bagianBs()->delete();

        // Save Bagian A
        if ($request->has('bagian_a') && is_array($request->bagian_a)) {
            foreach ($request->bagian_a as $item) {
                $ak07->bagianAs()->create([
                    'item' => $item['item'] ?? '',
                    'penyesuaian' => $item['penyesuaian'] ?? null
                ]);
            }
        }

        // Save Bagian B
        if ($request->has('bagian_b') && is_array($request->bagian_b)) {
            foreach ($request->bagian_b as $item) {
                $ak07->bagianBs()->create([
                    'item' => $item['item'] ?? '',
                    'penyesuaian' => $item['penyesuaian'] ?? null,
                    'lainnya' => $item['lainnya'] ?? ''
                ]);
            }
        }


        // Check if both asesi and asesor have signed, and if so, update progress
        if ($ak07->waktu_tanda_tangan_asesi && $ak07->waktu_tanda_tangan_asesor) {
            // Update the progres_asesmen table
            $this->progressService->completeStep(
                $request->id_asesi,
                'ak07',
                'Completed by Asesor ID: ' . $request->id_asesor . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
            );
            log::info('AK07 completed by Asesor', [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
                'timestamp' => Carbon::now()->format('d-m-Y H:i:s')
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data AK07 berhasil disimpan oleh Asesor',
            'data' => $ak07->load('hasilItems')
        ]);
    }
}
