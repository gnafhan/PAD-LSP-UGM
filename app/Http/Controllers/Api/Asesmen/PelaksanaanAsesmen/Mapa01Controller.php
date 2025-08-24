<?php

namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapa01;
use App\Models\RencanaAsesmen;
use App\Services\AsesmenValidationService;
use App\Models\TandaTanganAsesor;
use App\Services\ProgressTrackingService;
use App\Helpers\DateTimeHelper;

/**
 * @OA\Tag(
 *     name="MAPA01",
 *     description="API Endpoints untuk pengelolaan formulir MAPA01 (Merencanakan Aktifitas & Proses Asesmen)"
 * )
 */
class Mapa01Controller extends Controller
{

    protected $validationService;
    protected $progressService;

    public function __construct(AsesmenValidationService $validationService, ProgressTrackingService $progressService)
    {
        $this->validationService = $validationService;
        $this->progressService = $progressService;
    }

    /**
     * Get MAPA01 data for an Asesi
     *
     * @OA\Get(
     *     path="/asesmen/mapa01/{id_asesi}",
     *     summary="Mendapatkan data formulir MAPA01 untuk asesi",
     *     tags={"MAPA01"},
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
     *         description="Data formulir MAPA01",
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
     *                     @OA\Property(property="kode_skema", type="string", example="SKM-001")
     *                 ),
     *                 @OA\Property(
     *                     property="rencana_asesmen",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id_uk", type="string", example="UK-001"),
     *                         @OA\Property(property="kode_uk", type="string", example="UK001"),
     *                         @OA\Property(property="nama_uk", type="string", example="Mengembangkan Aplikasi Web"),
     *                         @OA\Property(
     *                             property="rencana",
     *                             type="array",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="elemen", type="string", example="Menyiapkan kebutuhan"),
     *                                 @OA\Property(property="bukti_bukti", type="string", example="Portofolio"),
     *                                 @OA\Property(property="jenis_bukti", type="string", example="L")
     *                             )
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="mapa01",
     *                     type="object",
     *                     @OA\Property(property="pendekatan_asesmen_asesi", type="string", example="Pendekatan asesmen yang digunakan"),
     *                     @OA\Property(property="tujuan_asesmen", type="string", example="Tujuan pelaksanaan asesmen"),
     *                     @OA\Property(property="lingkungan", type="string", example="Tempat kerja nyata"),
     *                     @OA\Property(property="peluang_untuk_mengumpulkan_bukti", type="string", example="Tersedia"),
     *                     @OA\Property(property="hubungan_antara_standar_kompetensi", type="string", example="Keterkaitan dengan standar industri"),
     *                     @OA\Property(property="pelaksana_asesmen", type="string", example="Tim asesor LSP UGM"),
     *                     @OA\Property(property="pihak_yang_relevan_untuk_dikonfirmasi", type="string", example="Atasan, rekan kerja, klien"),
     *                     @OA\Property(property="tolak_ukur_asesmen", type="string", example="Kriteria unjuk kerja dan pengetahuan pendukung"),
     *                     @OA\Property(property="waktu_tanda_tangan_asesor", type="string", format="date", example="2025-05-15", nullable=true),
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
     *     )
     * )
     */
    public function getMapa01(Request $request, $id_asesi)
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
        $id_skema = $asesi->id_skema;

        // Get MAPA01 data if it exists
        $mapa01 = Mapa01::where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->first();

        // Get rencana asesmen data
        $allRencanaAsesmen = RencanaAsesmen::where('id_skema', $id_skema)
            ->with('unitKompetensi')
            ->get();

        // Group rencana asesmen data by unit kompetensi
        $groupedRencanaAsesmen = [];
        foreach ($allRencanaAsesmen as $rencana) {
            if (!isset($groupedRencanaAsesmen[$rencana->id_uk])) {
                $groupedRencanaAsesmen[$rencana->id_uk] = [
                    'id_uk' => $rencana->id_uk,
                    'kode_uk' => $rencana->unitKompetensi->kode_uk,
                    'nama_uk' => $rencana->unitKompetensi->nama_uk,
                    'rencana' => []
                ];
            }

            // Get metode label
            $metodeMap = [
                'CL' => 'Daftar Periksa',
                'DIT' => 'Daftar Instruksi Terstruktur',
                'DPL' => 'Daftar Pertanyaan Lisan',
                'DPT' => 'Daftar Pertanyaan Tertulis',
                'VP' => 'Verifikasi Portofolio',
                'CUP' => 'Ceklis Ulasan Produk'
            ];
            $metodeLabel = $metodeMap[$rencana->metode_dan_perangkat_asesmen] ?? $rencana->metode_dan_perangkat_asesmen;

            $groupedRencanaAsesmen[$rencana->id_uk]['rencana'][] = [
                'elemen' => $rencana->elemen,
                'bukti_bukti' => $rencana->bukti_bukti,
                'jenis_bukti' => $rencana->jenis_bukti,
                'metode_dan_perangkat_asesmen' => $rencana->metode_dan_perangkat_asesmen,
                'metode_label' => $metodeLabel
            ];
        }

        // Convert to array for response
        $rencanaAsesmenArray = array_values($groupedRencanaAsesmen);

        // Prepare general information
        $generalInfo = [
            'nama_asesi' => $asesi->nama_asesi,
            'nama_asesor' => $asesor->nama_asesor,
            'nama_tuk' => $asesi->rincianAsesmen->event->tuk->nama_tuk,
            'judul_skema' => $asesi->skema->nama_skema,
            'kode_skema' => $asesi->skema->nomor_skema,
        ];

        // Check if the MAPA01 record exists
        if ($mapa01) {
            // Check if the asesor has a valid signature
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($mapa01->waktu_tanda_tangan_asesor);
            if ($tandaTanganAsesor) {
                $tandaTanganAsesor->file_url = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }

            // Record exists - return the record data
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'rencana_asesmen' => $rencanaAsesmenArray,
                    'mapa01' => [
                        'pendekatan_asesmen_asesi' => $mapa01->pendekatan_asesmen_asesi,
                        'tujuan_asesmen' => $mapa01->tujuan_asesmen,
                        'lingkungan' => $mapa01->lingkungan,
                        'peluang_untuk_mengumpulkan_bukti' => $mapa01->peluang_untuk_mengumpulkan_bukti,
                        'hubungan_antara_standar_kompetensi' => $mapa01->hubungan_antara_standar_kompetensi,
                        'pelaksana_asesmen' => $mapa01->pelaksana_asesmen,
                        'pihak_yang_relevan_untuk_dikonfirmasi' => $mapa01->pihak_yang_relevan_untuk_dikonfirmasi,
                        'tolak_ukur_asesmen' => $mapa01->tolak_ukur_asesmen,
                        'waktu_tanda_tangan_asesor' => $mapa01->waktu_tanda_tangan_asesor ? DateTimeHelper::toWIB($mapa01->waktu_tanda_tangan_asesor) : null,
                        'tanda_tangan_asesor' => $tandaTanganAsesor ? $tandaTanganAsesor->file_url : null,
                    ],
                    'record_exists' => true
                ]
            ]);
        } else {
            // Record doesn't exist - provide only general information and rencana asesmen
            return response()->json([
                'status' => 'success',
                'data' => [
                    'general_info' => $generalInfo,
                    'rencana_asesmen' => $rencanaAsesmenArray,
                    'record_exists' => false
                ]
            ]);
        }
    }

    /**
     * Create or update MAPA01 data for Asesor
     *
     * @OA\Post(
     *     path="/asesmen/mapa01/save",
     *     summary="Menyimpan data formulir MAPA01 oleh Asesor",
     *     tags={"MAPA01"},
     *     security={{"api_key":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_asesi", "id_asesor", "lingkungan", "peluang_untuk_mengumpulkan_bukti", "hubungan_antara_standar_kompetensi", "pelaksana_asesmen", "pihak_yang_relevan_untuk_dikonfirmasi", "tolak_ukur_asesmen"},
     *             @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     *             @OA\Property(property="id_asesor", type="string", example="ASESOR2025XXXXX"),
     *             @OA\Property(property="pendekatan_asesmen_asesi", type="string", example="Pekerja Berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi"),
     *             @OA\Property(property="tujuan_asesmen", type="string", example="Sertifikasi"),
     *             @OA\Property(property="lingkungan", type="string", example="Tempat kerja nyata"),
     *             @OA\Property(property="peluang_untuk_mengumpulkan_bukti", type="string", example="Tersedia"),
     *             @OA\Property(property="hubungan_antara_standar_kompetensi", type="string", example="	Bukti untuk mendukung asesmen / RPL"),
     *             @OA\Property(property="pelaksana_asesmen", type="string", example="	Oleh Lembaga Sertifikasi"),
     *             @OA\Property(property="pihak_yang_relevan_untuk_dikonfirmasi", type="string", example="Manajer sertifikasi LSP"),
     *             @OA\Property(property="tolak_ukur_asesmen", type="string", example="Kriteria asesmen dari kurikulum pelatihan"),
     *             @OA\Property(property="is_signing", type="boolean", example=true, description="Set to true if the asesor is signing the form")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data MAPA01 berhasil disimpan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data MAPA01 berhasil disimpan"),
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
    public function saveMapa01(Request $request)
    {
        // Validate the request
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'pendekatan_asesmen_asesi' => 'required|string',
            'tujuan_asesmen' => 'required|string',
            'lingkungan' => 'required|string',
            'peluang_untuk_mengumpulkan_bukti' => 'required|string',
            'hubungan_antara_standar_kompetensi' => 'required|string',
            'pelaksana_asesmen' => 'required|string',
            'pihak_yang_relevan_untuk_dikonfirmasi' => 'required|string',
            'tolak_ukur_asesmen' => 'required|string',
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

        // Find or create MAPA01 record
        $mapa01 = Mapa01::firstOrNew([
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
        ]);

        // Update fields
        $mapa01->pendekatan_asesmen_asesi = $request->pendekatan_asesmen_asesi;
        $mapa01->tujuan_asesmen = $request->tujuan_asesmen;
        $mapa01->lingkungan = $request->lingkungan;
        $mapa01->peluang_untuk_mengumpulkan_bukti = $request->peluang_untuk_mengumpulkan_bukti;
        $mapa01->hubungan_antara_standar_kompetensi = $request->hubungan_antara_standar_kompetensi;
        $mapa01->pelaksana_asesmen = $request->pelaksana_asesmen;
        $mapa01->pihak_yang_relevan_untuk_dikonfirmasi = $request->pihak_yang_relevan_untuk_dikonfirmasi;
        $mapa01->tolak_ukur_asesmen = $request->tolak_ukur_asesmen;

        // Update asesor's signature timestamp if signing
        if ($request->boolean('is_signing')) {
            // check if asesor has a signature
            $tanda_tangan_asesor = TandaTanganAsesor::where('id_asesor', $request->id_asesor)->first();
            if ($tanda_tangan_asesor) {
                $mapa01->waktu_tanda_tangan_asesor = now();
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Asesor tidak memiliki tanda tangan',
                ], 422);
            }
        }

        $mapa01->save();

        // Update the progres_asesmen table if the asesor has signed
        if ($mapa01->waktu_tanda_tangan_asesor) {
            $this->progressService->completeStep(
                $request->id_asesi,
                'mapa01',
                'Completed by Asesor ID: ' . $request->id_asesor
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data MAPA01 berhasil disimpan',
            'data' => $mapa01
        ]);
    }
}
