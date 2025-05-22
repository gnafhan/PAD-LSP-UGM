<?php

namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\TandaTanganAsesor;
use Illuminate\Http\Request;
use App\Models\Asesi;
use App\Models\KonsultasiPraUji;
use App\Models\RincianAsesmen;
use Carbon\Carbon;
use App\Services\AsesmenValidationService;


/**
 * @OA\Tag(
 *     name="Konsultasi Pra Uji",
 *     description="API Endpoints untuk pengelolaan formulir Konsultasi Pra Uji"
 * )
 */
class KonsultasiPraUjiController extends Controller
{

    protected $validationService;
    
    public function __construct(AsesmenValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * Get KonsultasiPraUji data for an Asesi
     * 
     * @OA\Get(
     *     path="/asesmen/konsultasi-prauji/{id_asesi}",
     *     summary="Mendapatkan data formulir Konsultasi Pra Uji",
     *     tags={"Konsultasi Pra Uji"},
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
     *         description="Data formulir konsultasi pra uji",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="general_info",
     *                     type="object",
     *                     @OA\Property(
     *                         property="skema",
     *                         type="object",
     *                         @OA\Property(property="id_skema", type="string", example="SKEMA2025XXXXX"),
     *                         @OA\Property(property="nomor_skema", type="string", example="SKM-001"),
     *                         @OA\Property(property="nama_skema", type="string", example="Programmer")
     *                     ),
     *                     @OA\Property(
     *                         property="unit_kompetensi",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id_uk", type="string", example="UK2025XXXXX"),
     *                             @OA\Property(property="kode_uk", type="string", example="J.62.01.01"),
     *                             @OA\Property(property="nama_uk", type="string", example="Menganalisis Kebutuhan Software")
     *                         )
     *                     ),
     *                     @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *                     @OA\Property(property="nama_asesor", type="string", example="John Doe")
     *                 ),
     *                 @OA\Property(
     *                     property="konsultasi_pra_uji",
     *                     type="object",
     *                     @OA\Property(property="tanggal_asesmen_disepakati", type="string", format="date", example="2025-05-06"),
     *                     @OA\Property(property="waktu_pelaksanaan", type="string", example="09:00"),
     *                     @OA\Property(property="tempat_uji", type="string", example="JTTC"),
     *                     @OA\Property(property="ttd_asesi", type="boolean", example=true),
     *                     @OA\Property(property="tanda_tangan_asesor", type="string", nullable=true, example="signature/ttd_asesor.png"),
     *                     @OA\Property(
     *                         property="jawaban_checklist",
     *                         type="object",
     *                         @OA\Property(
     *                             property="point_1",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         ),
     *                         @OA\Property(
     *                             property="point_2",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         ),
     *                         @OA\Property(
     *                             property="point_3",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         ),
     *                         @OA\Property(
     *                             property="point_4",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         ),
     *                         @OA\Property(
     *                             property="point_5",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         ),
     *                         @OA\Property(
     *                             property="point_6",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         ),
     *                         @OA\Property(
     *                             property="point_7",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         ),
     *                         @OA\Property(
     *                             property="point_8",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         ),
     *                         @OA\Property(
     *                             property="point_9",
     *                             type="object",
     *                             @OA\Property(property="jawaban_asesi", type="string", nullable=true, example="Ya"),
     *                             @OA\Property(property="jawaban_asesor", type="string", nullable=true, example="Ya")
     *                         )
     *                     )
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
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Formulir prasyarat belum diselesaikan",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Formulir AK-01 (Formulir Persetujuan Asesmen) belum diselesaikan"),
     *             @OA\Property(property="missing_form", type="string", example="ak01"),
     *             @OA\Property(property="display_name", type="string", example="AK-01 (Formulir Persetujuan Asesmen)"),
     *             @OA\Property(property="code", type="integer", example=422)
     *         )
     *     )
     * )
     */
    public function getKonsultasiPraUji(Request $request, $id_asesi)
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

        // Check form dependencies 
        $dependencyResult = $this->validationService->validateFormDependencies($id_asesi, 'konsultasi_pra_uji');
        if ($dependencyResult) {
            return response()->json($dependencyResult, $dependencyResult['code']);
        }

        $asesor = $asesi->rincianAsesmen->asesor;
        $id_asesor = $asesor->id_asesor;
        
        // Get KonsultasiPraUji data if it exists
        $konsultasi = KonsultasiPraUji::where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->first();

        // Prepare general data - Skema information and UK list
        $skemaInfo = null;
        $unitKompetensiList = [];
        
        if ($asesi->skema) {
            $skemaInfo = [
                'id_skema' => $asesi->skema->id_skema,
                'nomor_skema' => $asesi->skema->nomor_skema,
                'nama_skema' => $asesi->skema->nama_skema,
            ];
            
            // Get Unit Kompetensi list
            if (!empty($asesi->skema->daftar_id_uk)) {
                $unitKompetensiList = $asesi->skema->unit_kompetensi->map(function ($uk) {
                    return [
                        'id_uk' => $uk->id_uk,
                        'kode_uk' => $uk->kode_uk,
                        'nama_uk' => $uk->nama_uk,
                    ];
                });
            }
        }

        // Check if the KonsultasiPraUji record exists
        if ($konsultasi) {
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($konsultasi->waktu_tanda_tangan_asesor);
            if ($tandaTanganAsesor) {
                $tandaTanganAsesor->file_url = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }
            // Record exists - return the record data
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => [
                        'skema' => $skemaInfo,
                        'unit_kompetensi' => $unitKompetensiList,
                        'id_asesor' => $id_asesor,
                        'nama_asesor' => $asesor->nama_asesor,
                    ],
                    'konsultasi_pra_uji' => [
                        'tanggal_asesmen_disepakati' => $konsultasi->tanggal_konsultasi,
                        'waktu_pelaksanaan' => $konsultasi->waktu_pelaksanaan,
                        'tempat_uji' => $konsultasi->tempat_uji,
                        'ttd_asesi' => $asesi->ttd_pemohon,
                        'ttd_asesor' => $tandaTanganAsesor->file_url ?? null,
                        'jawaban_checklist' => $konsultasi->jawaban_checklist,
                    ],
                    'record_exists' => true
                ]
            ]);
        } else {
            // Record doesn't exist - provide default values
            $tempatUji = null;
            $tanggalAsesmenDisepakati = $asesi->created_at->format('d-m-Y');
            
            // Try to get tempat_uji from rincianAsesmen->event->tuk
            if ($asesi->rincianAsesmen && $asesi->rincianAsesmen->event && $asesi->rincianAsesmen->event->tuk) {
                $tempatUji = $asesi->rincianAsesmen->event->tuk->nama_tuk;
            }
            
            // Generate default checklist structure
            $defaultChecklist = [
                'point_1' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
                'point_2' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
                'point_3' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
                'point_4' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
                'point_5' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
                'point_6' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
                'point_7' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
                'point_8' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
                'point_9' => ['jawaban_asesi' => null, 'jawaban_asesor' => null],
            ];
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => [
                        'skema' => $skemaInfo,
                        'unit_kompetensi' => $unitKompetensiList,
                        'id_asesor' => $id_asesor,
                        'nama_asesor' => $asesi->rincianAsesmen->asesor->nama_asesor,
                    ],
                    'konsultasi_pra_uji' => [
                        'tanggal_asesmen_disepakati' => $tanggalAsesmenDisepakati,
                        'waktu_pelaksanaan' => null,
                        'tempat_uji' => $tempatUji,
                        'ttd_asesi' => false,
                        'waktu_tanda_tangan_asesor' => null,
                        'jawaban_checklist' => $defaultChecklist,
                    ],
                    'record_exists' => false
                ]
            ]);
        }
    }

    /**
     * Create or update KonsultasiPraUji data for Asesi
     * 
     * @OA\Post(
     *     path="/asesmen/konsultasi-prauji/asesi/save",
     *     summary="Menyimpan data formulir Konsultasi Pra Uji oleh Asesi",
     *     tags={"Konsultasi Pra Uji"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor", "jawaban_checklist"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *             @OA\Property(
     *                 property="jawaban_checklist",
     *                 type="object",
     *                 @OA\Property(
     *                     property="point_1",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_2",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_3",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_4",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_5",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_6",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_7",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_8",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_9",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesi", type="string", example="Ya")
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data konsultasi pra uji berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data konsultasi pra uji berhasil disimpan oleh Asesi"),
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
     *         description="Validasi gagal atau formulir prasyarat belum diselesaikan",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function saveKonsultasiPraUjiAsesi(Request $request)
    {
        //Log
        \Log::info('Request to save KonsultasiPraUji by Asesi', [
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
            'jawaban_checklist' => $request->jawaban_checklist,
        ]);
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'jawaban_checklist' => 'required|array',
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

        // Check form dependencies
        $dependencyResult = $this->validationService->validateFormDependencies(
            $request->id_asesi, 
            'konsultasi_pra_uji'
        );
        if ($dependencyResult) {
            return response()->json($dependencyResult, $dependencyResult['code']);
        }

        // Find or create KonsultasiPraUji record
        $konsultasi = KonsultasiPraUji::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Update the fields
        $asesi = Asesi::find($request->id_asesi);
        $rincianAsesmen = RincianAsesmen::where('id_asesor', $request->id_asesor)
                          ->where('id_asesi', $request->id_asesi)
                          ->first();
        $konsultasi->tanggal_konsultasi = $asesi->created_at->format('d-m-Y');
        $konsultasi->waktu_pelaksanaan = $rincianAsesmen->event->getRentangWaktuAttribute();
        $konsultasi->tempat_uji = $rincianAsesmen->event->tuk->nama_tuk ?? $request->tempat_uji;
        
        // Update checklist answers for Asesi
        $jawaban_checklist = $konsultasi->jawaban_checklist ?? [];
        foreach ($request->jawaban_checklist as $point => $data) {
            if (isset($jawaban_checklist[$point])) {
                // Update only the asesi's answer
                $jawaban_checklist[$point]['jawaban_asesi'] = $data['jawaban_asesi'];
            } else {
                // Create new point if it doesn't exist
                $jawaban_checklist[$point] = [
                    'jawaban_asesi' => $data['jawaban_asesi'],
                    'jawaban_asesor' => null
                ];
            }
        }
        $konsultasi->jawaban_checklist = $jawaban_checklist;
        
        $konsultasi->save();

        // If the Asesi has signed and the Asesor has signed, update progressAsesmen status
        if ($konsultasi->jawaban_checklist['point_1']['jawaban_asesi'] == 'Ya' && $konsultasi->jawaban_checklist['point_1']['jawaban_asesor'] == 'Ya') {
            $asesi->progresAsesmen->konsultasi_pra_uji = true;
            $asesi->progresAsesmen->save();
                \Log::info('Konsultasi Pra Uji completed for Asesi', [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data konsultasi pra uji berhasil disimpan oleh Asesi',
            'data' => $konsultasi
        ]);
    }

    /**
     * Create or update KonsultasiPraUji data for Asesor
     * 
     * @OA\Post(
     *     path="/asesmen/konsultasi-prauji/asesor/save",
     *     summary="Menyimpan data formulir Konsultasi Pra Uji oleh Asesor",
     *     tags={"Konsultasi Pra Uji"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor", "jawaban_checklist"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *             @OA\Property(
     *                 property="jawaban_checklist",
     *                 type="object",
     *                 @OA\Property(
     *                     property="point_1",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_2",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_3",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_4",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_5",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_6",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_7",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_8",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 ),
     *                 @OA\Property(
     *                     property="point_9",
     *                     type="object",
     *                     @OA\Property(property="jawaban_asesor", type="string", example="Ya")
     *                 )
     *             ),
     *             @OA\Property(property="is_asesor_signing", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data konsultasi pra uji berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data konsultasi pra uji berhasil disimpan oleh Asesor"),
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
     *         description="Validasi gagal atau formulir prasyarat belum diselesaikan",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function saveKonsultasiPraUjiAsesor(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'jawaban_checklist' => 'required|array',
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

        // Check form dependencies
        $dependencyResult = $this->validationService->validateFormDependencies(
            $request->id_asesi, 
            'konsultasi_pra_uji'
        );
        if ($dependencyResult) {
            return response()->json($dependencyResult, $dependencyResult['code']);
        }

        // Find or create KonsultasiPraUji record
        $konsultasi = KonsultasiPraUji::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Update the fields
        $asesi = Asesi::find($request->id_asesi);
        $rincianAsesmen = RincianAsesmen::where('id_asesor', $request->id_asesor)
                          ->where('id_asesi', $request->id_asesi)
                          ->first();
        $konsultasi->tanggal_konsultasi = $asesi->created_at->format('d-m-Y');
        $konsultasi->waktu_pelaksanaan = $rincianAsesmen->event->getRentangWaktuAttribute();
        $konsultasi->tempat_uji = $rincianAsesmen->event->tuk->nama_tuk ?? $request->tempat_uji;
        $konsultasi->waktu_tanda_tangan_asesor = now();
        
        // Update checklist answers for Asesor
        $jawaban_checklist = $konsultasi->jawaban_checklist ?? [];
        foreach ($request->jawaban_checklist as $point => $data) {
            if (isset($jawaban_checklist[$point])) {
                // Update only the asesor's answer
                $jawaban_checklist[$point]['jawaban_asesor'] = $data['jawaban_asesor'];
            } else {
                // Create new point if it doesn't exist
                $jawaban_checklist[$point] = [
                    'jawaban_asesi' => null,
                    'jawaban_asesor' => $data['jawaban_asesor']
                ];
            }
        }
        $konsultasi->jawaban_checklist = $jawaban_checklist;
        
        // Update asesor's signature timestamp if signing
        if ($request->is_asesor_signing) {
            // check if asesor has a signature
            $tanda_tangan_asesor = TandaTanganAsesor::where('id_asesor', $request->id_asesor)->first();
            if ($tanda_tangan_asesor) {
                $konsultasi->waktu_tanda_tangan_asesor = now();                
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor tidak memiliki tanda tangan',
                ], 422);
            }
        }

        $konsultasi->save();

        // If the Asesi has signed and the Asesor has signed, update progressAsesmen status
        if ($konsultasi->jawaban_checklist['point_1']['jawaban_asesi'] == 'Ya' && $konsultasi->jawaban_checklist['point_1']['jawaban_asesor'] == 'Ya') {
            $asesi->progresAsesmen->konsultasi_pra_uji = true;
            $asesi->progresAsesmen->save();
            // Log
            \Log::info('Konsultasi Pra Uji completed for Asesi', [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data konsultasi pra uji berhasil disimpan oleh Asesor',
            'data' => $konsultasi
        ]);
    }
}
