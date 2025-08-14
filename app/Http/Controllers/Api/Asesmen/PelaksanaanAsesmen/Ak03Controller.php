<?php
namespace App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DateTimeHelper;
use App\Models\Ak03;
use App\Services\AsesmenValidationService;
use App\Services\ProgressTrackingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * @OA\Tag(
 * name="AK03",
 * description="API Endpoints untuk pengelolaan formulir AK03 (Umpan Balik Peserta)"
 * )
 */
class Ak03Controller extends Controller
{
    protected $validationService;
    protected $progressService;

    public function __construct(AsesmenValidationService $validationService, ProgressTrackingService $progressService)
    {
        $this->validationService = $validationService;
        $this->progressService = $progressService;
    }

    /**
     * Get AK03 data for an Asesi
     */
    public function getAk03(Request $request, $id_asesi)
    {
        // ... (Fungsi validasi asesi tetap sama)
        $asesiResult = $this->validationService->validateAsesiExists(
            $id_asesi,
            ['skema', 'rincianAsesmen.asesor', 'rincianAsesmen.event.tuk']
        );
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }
        $asesi = $asesiResult;

        $rincianResult = $this->validationService->validateRincianAsesmen($asesi);
        if ($rincianResult) {
            return response()->json($rincianResult, $rincianResult['code']);
        }
        $id_asesor = $asesi->rincianAsesmen->asesor->id_asesor;

        $ak03 = Ak03::with('umpanBalikItems')
            ->where('id_asesi', $id_asesi)
            ->where('id_asesor', $id_asesor)
            ->first();

        // ... (General Info tetap sama)
        $generalInfo = [
            'nama_asesi' => $asesi->nama_asesi,
            'nama_asesor' => $asesi->rincianAsesmen->asesor->nama_asesor,
            'nama_tuk' => $asesi->rincianAsesmen->event->tuk->nama_tuk,
            'judul_skema' => $asesi->skema->nama_skema,
            'kode_skema' => $asesi->skema->nomor_skema,
            'pelaksanaan_asesmen_disepakati_mulai' => $asesi->created_at->format('d-m-Y')
        ];

        $data = [
            'general_info' => $generalInfo,
            'record_exists' => (bool)$ak03,
            'ak03' => null,
        ];

        if ($ak03) {
            $data['ak03'] = [
                'waktu_tanda_tangan_asesi' => DateTimeHelper::toWIB($ak03->waktu_tanda_tangan_asesi),
                'tanda_tangan_asesi' => $ak03->waktu_tanda_tangan_asesi ? asset('storage/' . $asesi->ttd_pemohon) : null,
                'umpan_balik' => $ak03->umpanBalikItems,
                // =================================================================
                // PENAMBAHAN DATA UMPAN BALIK ASESOR UNTUK DIKIRIM KE FRONTEND
                // =================================================================
                'general_feedback' => $ak03->general_feedback,
                'umpan_balik_pencapaian' => $ak03->umpan_balik_pencapaian,
                'saran_tindak_lanjut' => $ak03->saran_tindak_lanjut,
                'catatan_pencapaian_kompetensi' => $ak03->catatan_pencapaian_kompetensi,
                // =================================================================
            ];
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Create or update AK03 data for Asesi
     */
    public function saveAk03Asesi(Request $request)
    {
        // Fungsi ini tetap sama, khusus untuk menyimpan data dari asesi
        $validated = $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'is_signing' => 'required|boolean',
            'umpan_balik' => 'required|array',
            'umpan_balik.*.komponen_id' => 'required|integer',
            'umpan_balik.*.hasil' => 'nullable|string|in:ya,tidak',
            'umpan_balik.*.catatan' => 'nullable|string|max:255',
        ]);

        $asesiResult = $this->validationService->validateAsesiExists($validated['id_asesi'], ['rincianAsesmen.asesor']);
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }
        $asesi = $asesiResult;
        $id_asesor = $asesi->rincianAsesmen->asesor->id_asesor;

        try {
            DB::transaction(function () use ($validated, $id_asesor, $asesi) {
                $ak03 = Ak03::firstOrNew([
                    'id_asesi' => $validated['id_asesi'],
                    'id_asesor' => $id_asesor,
                ]);

                if ($validated['is_signing'] && !$ak03->waktu_tanda_tangan_asesi) {
                    $ak03->waktu_tanda_tangan_asesi = now();
                }
                
                // Hapus baris 'general_feedback' dari sini jika hanya diisi oleh Asesor
                // $ak03->general_feedback = $validated['general_feedback']; 
                
                $ak03->save();

                $ak03->umpanBalikItems()->delete();
                foreach ($validated['umpan_balik'] as $item) {
                    $ak03->umpanBalikItems()->create($item);
                }

                if ($validated['is_signing']) {
                    $this->progressService->completeStep(
                        $validated['id_asesi'],
                        'umpan_balik',
                        'Completed by Asesi at ' . Carbon::now()->format('d-m-Y H:i:s')
                    );
                    Log::info('AK03 completed by Asesi', ['id_asesi' => $validated['id_asesi']]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Failed to save AK03 data for Asesi', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan data umpan balik asesi: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Umpan Balik Asesi berhasil disimpan.',
        ]);
    }
    
    // =================================================================
    // FUNGSI BARU UNTUK MENYIMPAN UMPAN BALIK DARI ASESOR
    // Anda perlu membuat route baru untuk fungsi ini, contoh:
    // Route::post('/asesmen/ak03/asesor/save', [Ak03Controller::class, 'saveAk03Asesor']);
    // =================================================================
    /**
     * @OA\Post(
     * path="/asesmen/ak03/asesor/save",
     * summary="Menyimpan umpan balik dan catatan dari Asesor pada formulir AK03",
     * tags={"AK03"},
     * security={{"api_key":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"id_asesi"},
     * @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     * @OA\Property(property="umpan_balik_pencapaian", type="string", example="Pencapaian sudah baik."),
     * @OA\Property(property="saran_tindak_lanjut", type="string", example="Tingkatkan pemahaman pada unit X."),
     * @OA\Property(property="catatan_pencapaian_kompetensi", type="string", example="Tidak ada kesenjangan."),
     * @OA\Property(property="rekomendasi", type="string", example="Secara umum sudah kompeten.")
     * )
     * ),
     * @OA\Response(response=200, description="Data AK03 dari Asesor berhasil disimpan"),
     * @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function saveAk03Asesor(Request $request)
    {
        $validated = $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'umpan_balik_pencapaian' => 'nullable|string',
            'saran_tindak_lanjut' => 'nullable|string',
            'catatan_pencapaian_kompetensi' => 'nullable|string',
            'rekomendasi' => 'nullable|string', // Sesuai dengan id="rekomendasi" di form
        ]);

        $asesiResult = $this->validationService->validateAsesiExists($validated['id_asesi'], ['rincianAsesmen.asesor']);
        if (isset($asesiResult['error'])) {
            return response()->json($asesiResult, $asesiResult['code']);
        }
        $asesi = $asesiResult;
        $id_asesor = $asesi->rincianAsesmen->asesor->id_asesor;

        try {
            DB::transaction(function () use ($validated, $id_asesor) {
                $ak03 = Ak03::firstOrNew([
                    'id_asesi' => $validated['id_asesi'],
                    'id_asesor' => $id_asesor,
                ]);

                // Simpan data dari form ke kolom yang sesuai
                $ak03->umpan_balik_pencapaian = $validated['umpan_balik_pencapaian'] ?? null;
                $ak03->saran_tindak_lanjut = $validated['saran_tindak_lanjut'] ?? null;
                $ak03->catatan_pencapaian_kompetensi = $validated['catatan_pencapaian_kompetensi'] ?? null;
                $ak03->general_feedback = $validated['rekomendasi'] ?? null; // 'rekomendasi' dari form disimpan sebagai 'general_feedback'
                
                $ak03->save();

                Log::info('AK03 feedback from Asesor saved', ['id_asesi' => $validated['id_asesi']]);
            });
        } catch (\Exception $e) {
            Log::error('Failed to save AK03 Asesor feedback', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan umpan balik asesor: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Umpan Balik dari Asesor berhasil disimpan.',
        ]);
    }

}