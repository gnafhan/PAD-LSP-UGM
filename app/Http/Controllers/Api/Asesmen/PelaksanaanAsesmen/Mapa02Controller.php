<?php

namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\Mapa02;
use App\Models\RincianAsesmen;
use Carbon\Carbon;
use App\Services\AsesmenValidationService;

/**
 * @OA\Tag(
 *     name="MAPA.02",
 *     description="API Endpoints untuk pengelolaan formulir MAPA.02 (Peta Instrumen Asesmen)"
 * )
 */
class Mapa02Controller extends Controller
{
    protected $validationService;
    
    public function __construct(AsesmenValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * Get Mapa02 data for an Asesi
     * 
     * @OA\Get(
     *     path="/asesmen/mapa02/{id_asesi}",
     *     summary="Mendapatkan data formulir MAPA.02 untuk asesi",
     *     tags={"MAPA.02"},
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
     *         description="Data formulir MAPA.02",
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
     *                     @OA\Property(property="judul_skema", type="string", example="Programmer"),
     *                     @OA\Property(property="kode_skema", type="string", example="SKM-001")
     *                 ),
     *                 @OA\Property(
     *                     property="mapa02",
     *                     type="object",
     *                     @OA\Property(property="muk_ceklis_observasi", type="integer", example=1),
     *                     @OA\Property(property="muk_tugas_praktik_demonstrasi", type="integer", example=1),
     *                     @OA\Property(property="muk_pertanyaan_tertulis_esai", type="integer", example=0),
     *                     @OA\Property(property="muk_pertanyaan_lisan", type="integer", example=1),
     *                     @OA\Property(property="muk_ceklis_verifikasi_portfolio", type="integer", example=0),
     *                     @OA\Property(property="muk_ceklis_meninjau_materi_uji", type="integer", example=1),
     *                     @OA\Property(property="waktu_tanda_tangan_asesor", type="string", format="date", example="2025-05-15"),
     *                     @OA\Property(property="tanda_tangan_asesor", type="string", format="date", example="signature/ttd_asesor.png"),
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
     *             @OA\Property(property="message", type="string", example="Formulir MAPA-01 (Merencanakan Aktivitas) belum diselesaikan"),
     *             @OA\Property(property="missing_form", type="string", example="mapa01"),
     *             @OA\Property(property="display_name", type="string", example="MAPA-01 (Merencanakan Aktivitas)"),
     *             @OA\Property(property="code", type="integer", example=422)
     *         )
     *     )
     * )
     */
    public function getMapa02(Request $request, $id_asesi)
    {
        // Validate Asesi exists
        $asesiResult = $this->validationService->validateAsesiExists(
            $id_asesi, 
            ['skema', 'rincianAsesmen.asesor']
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

        // Check form dependencies - MAPA.02 depends on MAPA.01
        $dependencyResult = $this->validationService->validateFormDependencies($id_asesi, 'mapa02');
        if ($dependencyResult) {
            return response()->json($dependencyResult, $dependencyResult['code']);
        }

        $asesor = $asesi->rincianAsesmen->asesor;
        $id_asesor = $asesor->id_asesor;
        
        // Get MAPA.02 data if it exists
        $mapa02 = Mapa02::where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->first();

        // Prepare general information
        $generalInfo = [
            'nama_asesi' => $asesi->nama_asesi,
            'nama_asesor' => $asesi->rincianAsesmen->asesor->nama_asesor,
            'judul_skema' => $asesi->skema->nama_skema,
            'kode_skema' => $asesi->skema->nomor_skema
        ];

        // Check if the MAPA.02 record exists
        if ($mapa02) {
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($mapa02->waktu_tanda_tangan_asesor);
            if ($tandaTanganAsesor) {
                $tandaTanganAsesor->file_url = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }
            // Record exists - return the record data
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'mapa02' => [
                        'muk_ceklis_observasi' => $mapa02->muk_ceklis_observasi,
                        'muk_tugas_praktik_demonstrasi' => $mapa02->muk_tugas_praktik_demonstrasi,
                        'muk_pertanyaan_tertulis_esai' => $mapa02->muk_pertanyaan_tertulis_esai,
                        'muk_pertanyaan_lisan' => $mapa02->muk_pertanyaan_lisan,
                        'muk_ceklis_verifikasi_portfolio' => $mapa02->muk_ceklis_verifikasi_portfolio,
                        'muk_ceklis_meninjau_materi_uji' => $mapa02->muk_ceklis_meninjau_materi_uji,
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
                    'record_exists' => false
                ]
            ]);
        }
    }

    /**
     * Create or update Mapa02 data
     * 
     * @OA\Post(
     *     path="/asesmen/mapa02/save",
     *     summary="Menyimpan data formulir MAPA.02",
     *     tags={"MAPA.02"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor", "muk_ceklis_observasi", "muk_tugas_praktik_demonstrasi", 
     *                      "muk_pertanyaan_tertulis_esai", "muk_pertanyaan_lisan", 
     *                      "muk_ceklis_verifikasi_portfolio", "muk_ceklis_meninjau_materi_uji"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *             @OA\Property(property="muk_ceklis_observasi", type="integer", example=1),
     *             @OA\Property(property="muk_tugas_praktik_demonstrasi", type="integer", example=4),
     *             @OA\Property(property="muk_pertanyaan_tertulis_esai", type="integer", example=3),
     *             @OA\Property(property="muk_pertanyaan_lisan", type="integer", example=5),
     *             @OA\Property(property="muk_ceklis_verifikasi_portfolio", type="integer", example=3),
     *             @OA\Property(property="muk_ceklis_meninjau_materi_uji", type="integer", example=2),
     *             @OA\Property(property="is_signing", type="boolean", example=true, description="Set to true if the asesor is signing the form")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data MAPA.02 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data MAPA.02 berhasil disimpan"),
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
    public function saveMapa02(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'muk_ceklis_observasi' => 'required|integer|min:1|max:5',
            'muk_tugas_praktik_demonstrasi' => 'required|integer|min:1|max:5',
            'muk_pertanyaan_tertulis_esai' => 'required|integer|min:1|max:5',
            'muk_pertanyaan_lisan' => 'required|integer|min:1|max:5',
            'muk_ceklis_verifikasi_portfolio' => 'required|integer|min:1|max:5',
            'muk_ceklis_meninjau_materi_uji' => 'required|integer|min:1|max:5',
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

        // Check form dependencies - MAPA.02 depends on MAPA.01
        $dependencyResult = $this->validationService->validateFormDependencies(
            $request->id_asesi, 
            'mapa02'
        );
        if ($dependencyResult) {
            return response()->json($dependencyResult, $dependencyResult['code']);
        }

        // Find or create Mapa02 record
        $mapa02 = Mapa02::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Update the fields
        $mapa02->muk_ceklis_observasi = $request->muk_ceklis_observasi;
        $mapa02->muk_tugas_praktik_demonstrasi = $request->muk_tugas_praktik_demonstrasi;
        $mapa02->muk_pertanyaan_tertulis_esai = $request->muk_pertanyaan_tertulis_esai;
        $mapa02->muk_pertanyaan_lisan = $request->muk_pertanyaan_lisan;
        $mapa02->muk_ceklis_verifikasi_portfolio = $request->muk_ceklis_verifikasi_portfolio;
        $mapa02->muk_ceklis_meninjau_materi_uji = $request->muk_ceklis_meninjau_materi_uji;
        
        // Set the signing timestamp if the asesor is signing
        if ($request->boolean('is_signing')) {
            $mapa02->waktu_tanda_tangan_asesor = Carbon::now();
            
            // Update the progres_asesmen table
            $asesi = Asesi::find($request->id_asesi);
            if ($asesi && $asesi->progresAsesmen) {
                $asesi->progresAsesmen->mapa02 = true;
                $asesi->progresAsesmen->save();
            }
        }

        $mapa02->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data MAPA.02 berhasil disimpan',
            'data' => $mapa02
        ]);
    }
}