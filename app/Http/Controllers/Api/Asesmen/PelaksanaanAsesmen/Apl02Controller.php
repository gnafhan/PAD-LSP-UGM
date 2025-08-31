<?php

namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use App\Models\Apl02;
use App\Models\Apl02Kompetensi;
use App\Models\TandaTanganAsesor;
use App\Services\AsesmenValidationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ProgressTrackingService;
use App\Helpers\DateTimeHelper;

/**
 * @OA\Tag(
 *     name="APL02",
 *     description="API Endpoints untuk pengelolaan formulir APL02"
 * )
 */
class Apl02Controller extends Controller
{
    protected $validationService;
    protected $progressService;

    
    public function __construct(AsesmenValidationService $validationService, ProgressTrackingService $progressService)
    {
        $this->validationService = $validationService;
        $this->progressService = $progressService;

    }

    /**
     * Get APL02 data for an Asesor
     * 
     * @OA\Get(
     *     path="/asesmen/apl02/asesor/{id_asesi}",
     *     summary="Mendapatkan data formulir APL02 untuk asesor",
     *     tags={"APL02"},
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
     *         description="Data formulir APL02",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data", 
     *                 type="object",
     *                 @OA\Property(
     *                     property="general_info",
     *                     type="object",
     *                     @OA\Property(property="nama_asesi", type="string", example="John Doe"),
     *                     @OA\Property(property="nama_tuk", type="string", example="TUK XYZ"),
     *                     @OA\Property(property="nama_asesor", type="string", example="Joko Wi"),
     *                     @OA\Property(property="nama_skema", type="string", example="Programmer"),
     *                     @OA\Property(property="nomor_skema", type="string", example="SKM/0317/00010/2/2019/22")
     *                 ),
     *                 @OA\Property(property="detail_skema", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="record_exists", type="boolean", example=true),
     *                 @OA\Property(
     *                     property="detail_apl02",
     *                     type="object",
     *                     @OA\Property(property="waktu_tanda_tangan_asesor", type="string", format="date-time"),
     *                     @OA\Property(property="waktu_tanda_tangan_asesi", type="string", format="date-time", nullable=true),
     *                     @OA\Property(property="ttd_asesor", type="string", example="url/to/signature.png"),
     *                     @OA\Property(property="ttd_asesi", type="string", example="url/to/signature.png", nullable=true),
     *                     @OA\Property(property="rekomendasi", type="string"),
     *                     @OA\Property(property="metode_uji", type="string")
     *                 )
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
    public function getApl02Asesor(Request $request, $id_asesi)
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
        $id_skema = $asesi->skema->id_skema;
        
        // Get APL02 data if it exists
        $apl02 = Apl02::where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->first();

        // Prepare general info
        $generalInfo = [
            'nama_asesi' => $asesi->nama_asesi,
            'nama_tuk' => $asesi->rincianAsesmen->event->tuk->nama_tuk ?? 'TUK tidak tersedia',
            'nama_asesor' => $asesi->rincianAsesmen->asesor->nama_asesor ?? 'Nama Asesor tidak tersedia',
            'nama_skema' => $asesi->skema->nama_skema,
            'nomor_skema' => $asesi->skema->nomor_skema,
        ];

        // Check if the APL02 record exists
        if ($apl02) {
            // Get asesor signature
            $tandaTanganAsesor = null;
            if ($apl02->waktu_tanda_tangan_asesor) {
                $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($apl02->waktu_tanda_tangan_asesor);
                if ($tandaTanganAsesor) {
                    $tandaTanganAsesor = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
                }
            }
            
            // Get asesi signature
            $tandaTanganAsesi = null;
            if ($apl02->waktu_tanda_tangan_asesi && $asesi->ttd_pemohon) {
                $tandaTanganAsesi = asset('storage/' . $asesi->ttd_pemohon);
            }
            
            // Format detail APL02
            $detailApl02 = [
             'waktu_tanda_tangan_asesor' => DateTimeHelper::toWIB($apl02->waktu_tanda_tangan_asesor),
                'waktu_tanda_tangan_asesi' => DateTimeHelper::toWIB($apl02->waktu_tanda_tangan_asesi),
                'ttd_asesor' => $tandaTanganAsesor,
                'ttd_asesi' => $tandaTanganAsesi,
                'rekomendasi' => $apl02->rekomendasi,
                'metode_uji' => $apl02->metode_uji,
            ];
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'detail_skema' => $apl02->getDetailSkema(),
                    'detail_apl02' => $detailApl02,
                    'record_exists' => true
                ]
            ]);
        } else {
            // Record doesn't exist - provide default values and schema structure
            $skema = $asesi->skema;
            $detailSkema = [];
            
            if ($skema) {
                $unitKompetensiList = $skema->getUnitKompetensi();
                foreach ($unitKompetensiList as $uk) {
                    $unitData = [
                        'id_uk' => $uk->id_uk,
                        'kode_uk' => $uk->kode_uk,
                        'nama_uk' => $uk->nama_uk,
                        'elemen_uk' => []
                    ];
                    
                    foreach ($uk->elemen_uk as $elemen) {
                        $unitData['elemen_uk'][] = [
                            'nama_elemen' => $elemen->nama_elemen,
                            'kompeten' => null // Null because not yet assessed
                        ];
                    }
                    
                    $detailSkema[] = $unitData;
                }
            }
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'detail_skema' => $detailSkema,
                    'record_exists' => false
                ]
            ]);
        }
    }

    /**
     * Get APL02 data for an Asesi
     * 
     * @OA\Get(
     *     path="/asesmen/apl02/asesi/{id_asesi}",
     *     summary="Mendapatkan data formulir APL02 untuk asesi",
     *     tags={"APL02"},
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
     *         description="Data formulir APL02",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="general_info",
     *                     type="object",
     *                     @OA\Property(property="nama_asesi", type="string", example="John Doe"),
     *                     @OA\Property(property="nama_tuk", type="string", example="TUK XYZ"),
     *                     @OA\Property(property="nama_skema", type="string", example="Programmer")
     *                 ),
     *                 @OA\Property(property="detail_skema", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="record_exists", type="boolean", example=true),
     *                 @OA\Property(
     *                     property="detail_apl02",
     *                     type="object",
     *                     @OA\Property(property="waktu_tanda_tangan_asesor", type="string", format="date-time"),
     *                     @OA\Property(property="waktu_tanda_tangan_asesi", type="string", format="date-time", nullable=true),
     *                     @OA\Property(property="ttd_asesor", type="string", example="url/to/signature.png"),
     *                     @OA\Property(property="ttd_asesi", type="string", example="url/to/signature.png", nullable=true)
     *                 )
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
    public function getApl02Asesi(Request $request, $id_asesi)
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
        
        // Get APL02 data if it exists
        $apl02 = Apl02::where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->first();

        // Prepare general info
        $generalInfo = [
            'nama_asesi' => $asesi->nama_asesi,
            'nama_tuk' => $asesi->rincianAsesmen->event->tuk->nama_tuk ?? 'TUK tidak tersedia',
            'nama_skema' => $asesi->skema->nama_skema,
        ];

        // Check if the APL02 record exists
        if ($apl02) {
            // Get asesor signature
            $tandaTanganAsesor = null;
            if ($apl02->waktu_tanda_tangan_asesor) {
                $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($apl02->waktu_tanda_tangan_asesor);
                if ($tandaTanganAsesor) {
                    $tandaTanganAsesor = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
                }
            }
            
            // Get asesi signature
            $tandaTanganAsesi = null;
            if ($apl02->waktu_tanda_tangan_asesi && $asesi->ttd_pemohon) {
                $tandaTanganAsesi = asset('storage/' . $asesi->ttd_pemohon);
            }
            
            // Format detail APL02 - simpler for asesi view
            $detailApl02 = [
                'waktu_tanda_tangan_asesor' => DateTimeHelper::toWIB($apl02->waktu_tanda_tangan_asesor),
                'waktu_tanda_tangan_asesi' => DateTimeHelper::toWIB($apl02->waktu_tanda_tangan_asesi),
                'ttd_asesor' => $tandaTanganAsesor,
                'ttd_asesi' => $tandaTanganAsesi
            ];
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'detail_skema' => $apl02->getDetailSkema(),
                    'detail_apl02' => $detailApl02,
                    'record_exists' => true
                ]
            ]);
        } else {
            // Record doesn't exist - inform the asesi
            return response()->json([
                'status' => 'info',
                'message' => 'Formulir APL02 belum dibuat oleh asesor',
                'data' => [
                    'general_info' => $generalInfo,
                    'record_exists' => false
                ]
            ]);
        }
    }

    /**
     * Create or update APL02 data for Asesor
     * 
     * @OA\Post(
     *     path="/asesmen/apl02/asesor/save",
     *     summary="Menyimpan data formulir APL02 oleh Asesor",
     *     tags={"APL02"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor", "rekomendasi", "metode_uji", "detail_kompetensi", "is_signing"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *             @OA\Property(property="rekomendasi", type="string", example="Asesi dinyatakan kompeten"),
     *             @OA\Property(property="metode_uji", type="string", example="Observasi dan Wawancara"),
     *             @OA\Property(
     *                 property="detail_kompetensi",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id_unit_kompetensi", type="string", example="UK202500001"),
     *                     @OA\Property(property="kode_unit", type="string", example="J.620100.009.02"),
     *                     @OA\Property(property="nama_unit", type="string", example="Melakukan coding sederhana"),
     *                     @OA\Property(
     *                         property="elemen_uk",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="nama_elemen", type="string", example="Mengidentifikasi kebutuhan coding"),
     *                             @OA\Property(property="kompeten", type="boolean", example=true)
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="is_signing", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data APL02 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data APL02 berhasil disimpan oleh Asesor"),
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
    public function saveApl02Asesor(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'rekomendasi' => 'required|string',
            'metode_uji' => 'required|string',
            'detail_kompetensi' => 'required|array',
            'detail_kompetensi.*.id_uk' => 'required|string',
            'detail_kompetensi.*.kode_uk' => 'required|string',
            'detail_kompetensi.*.nama_uk' => 'required|string',
            'detail_kompetensi.*.elemen_uk' => 'required|array',
            'detail_kompetensi.*.elemen_uk.*.nama_elemen' => 'required|string',
            'detail_kompetensi.*.elemen_uk.*.kompeten' => 'required|boolean',
            'is_signing' => 'required|boolean',
        ]);

        // Validate Asesi exists
        $asesiResult = $this->validationService->validateAsesiExists($request->id_asesi);
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }
        
        $asesi = $asesiResult;
        
        // Validate Asesi-Asesor pair
        $pairResult = $this->validationService->validateAsesiAsesorPair(
            $request->id_asesi, 
            $request->id_asesor
        );
        if ($pairResult) {
            return response()->json($pairResult, $pairResult['code']);
        }

        // Start transaction
        DB::beginTransaction();
        
        try {
            // Get id_skema from asesi
            $id_skema = $asesi->id_skema;
            
            // Find or create APL02 record
            $apl02 = Apl02::firstOrNew([
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
            ]);
            
            // Set values
            $apl02->id_skema = $id_skema;
            $apl02->rekomendasi = $request->rekomendasi;
            $apl02->metode_uji = $request->metode_uji;
            
            // Set signature timestamp if signing
            if ($request->is_signing) {
                // Check if asesor has a signature
                $tanda_tangan_asesor = TandaTanganAsesor::where('id_asesor', $request->id_asesor)->first();
                if ($tanda_tangan_asesor) {
                    $apl02->waktu_tanda_tangan_asesor = Carbon::now();                
                } else {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Asesor tidak memiliki tanda tangan',
                    ], 422);
                }
            }
            
            // Save the main APL02 record first to get the ID
            $apl02->save();
            
            // Delete existing kompetensi data if any
            Apl02Kompetensi::where('id_apl02', $apl02->id)->delete();
            
            // Create new kompetensi data
            foreach ($request->detail_kompetensi as $unit) {
                foreach ($unit['elemen_uk'] as $elemen) {
                    Apl02Kompetensi::create([
                        'id_apl02' => $apl02->id,
                        'id_uk' => $unit['id_uk'],
                        'kode_uk' => $unit['kode_uk'],
                        'nama_uk' => $unit['nama_uk'],
                        'nama_elemen' => $elemen['nama_elemen'],
                        'kompeten' => $elemen['kompeten'],
                    ]);
                }
            }
            
            DB::commit();
            
            if ($apl02->waktu_tanda_tangan_asesi && $apl02->waktu_tanda_tangan_asesor) {
                // If both signatures are present, update the APL02 status
                // Update progress
                $this->progressService->completeStep(
                    $request->id_asesi, 
                    'apl02', 
                    'Completed by Asesor ID: ' . $request->id_asesor . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
                );   
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data APL02 berhasil disimpan oleh Asesor',
                'data' => $apl02
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data APL02: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Sign APL02 data by Asesi
     * 
     * @OA\Post(
     *     path="/asesmen/apl02/asesi/sign",
     *     summary="Menandatangani formulir APL02 oleh Asesi",
     *     tags={"APL02"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor", "is_signing"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *             @OA\Property(property="is_signing", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="APL02 berhasil ditandatangani",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="APL02 berhasil ditandatangani oleh Asesi"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Asesi tidak ditemukan atau APL02 belum dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="APL02 belum dibuat oleh asesor"),
     *             @OA\Property(property="code", type="integer", example=404)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Asesi belum memiliki tanda tangan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Asesi belum memiliki tanda tangan")
     *         )
     *     )
     * )
     */
    public function signApl02Asesi(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'is_signing' => 'required|boolean',
        ]);

        // Validate Asesi exists
        $asesiResult = $this->validationService->validateAsesiExists($request->id_asesi);
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }
        
        $asesi = $asesiResult;
        
        // Validate Asesi-Asesor pair
        $pairResult = $this->validationService->validateAsesiAsesorPair(
            $request->id_asesi, 
            $request->id_asesor
        );
        if ($pairResult) {
            return response()->json($pairResult, $pairResult['code']);
        }

        // Find APL02 record
        $apl02 = Apl02::where('id_asesi', $request->id_asesi)
            ->where('id_asesor', $request->id_asesor)
            ->first();
            
        if (!$apl02) {
            return response()->json([
                'error' => true,
                'message' => 'APL02 belum dibuat oleh asesor',
                'code' => 404
            ], 404);
        }
        
        // Check if Asesor has signed first
        if (!$apl02->waktu_tanda_tangan_asesor) {
            return response()->json([
                'error' => true,
                'message' => 'APL02 belum ditandatangani oleh asesor',
                'code' => 422
            ], 422);
        }
        
        // Check if Asesi has a signature
        if ($request->is_signing && !$asesi->ttd_pemohon) {
            return response()->json([
                'status' => 'error',
                'message' => 'Asesi belum memiliki tanda tangan',
            ], 422);
        }
        
        // Set signature timestamp
        if ($request->is_signing) {
            $apl02->waktu_tanda_tangan_asesi = Carbon::now();
            $apl02->save();
            
            if ($apl02->waktu_tanda_tangan_asesi && $apl02->waktu_tanda_tangan_asesor) {
                // If both signatures are present, update the APL02 status
                // Update progress
                $this->progressService->completeStep(
                    $request->id_asesi, 
                    'apl02', 
                    'Completed by Asesi ID: ' . $request->id_asesi . ' at ' . Carbon::now()->format('d-m-Y H:i:s')
                );
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'APL02 berhasil ditandatangani oleh Asesi',
                'data' => $apl02
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Tidak ada perubahan pada APL02',
            'data' => $apl02
        ]);
    }
}