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
     *
     * @OA\Get(
     * path="/asesmen/ak03/{id_asesi}",
     * summary="Mendapatkan data formulir AK03 untuk asesi",
     * tags={"AK03"},
     * security={{"api_key":{}}},
     * @OA\Parameter(name="id_asesi", in="path", required=true, description="ID asesi", @OA\Schema(type="string")),
     * @OA\Response(
     * response=200,
     * description="Data formulir AK03",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="data", type="object",
     * @OA\Property(property="general_info", type="object",
     * @OA\Property(property="nama_asesi", type="string", example="John Doe"),
     * @OA\Property(property="nama_asesor", type="string", example="Jane Smith"),
     * @OA\Property(property="nama_tuk", type="string", example="TUK JTTC"),
     * @OA\Property(property="judul_skema", type="string", example="Programmer"),
     * @OA\Property(property="kode_skema", type="string", example="SKM-001"),
     * @OA\Property(property="pelaksanaan_asesmen_disepakati_mulai", type="string", format="date", example="23-07-2025")
     * ),
     * @OA\Property(property="ak03", type="object",
     * @OA\Property(property="waktu_tanda_tangan_asesi", type="string", format="date", example="23-07-2025 18:22:00", nullable=true),
     * @OA\Property(property="tanda_tangan_asesi", type="string", format="url", example="http://localhost/storage/signature/ttd_asesi.png", nullable=true),
     * @OA\Property(property="umpan_balik", type="array", @OA\Items(type="object",
     * @OA\Property(property="komponen_id", type="integer", example=1),
     * @OA\Property(property="hasil", type="string", example="ya"),
     * @OA\Property(property="catatan", type="string", example="Penjelasan sangat jelas.")
     * ))
     * ),
     * @OA\Property(property="record_exists", type="boolean", example=true)
     * )
     * )
     * ),
     * @OA\Response(response=404, description="Asesi tidak ditemukan")
     * )
     */
    public function getAk03(Request $request, $id_asesi)
    {
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
            ];
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Create or update AK03 data for Asesi
     *
     * @OA\Post(
     * path="/asesmen/ak03/asesi/save",
     * summary="Menyimpan umpan balik dan tanda tangan Asesi pada formulir AK03",
     * tags={"AK03"},
     * security={{"api_key":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"id_asesi", "umpan_balik", "is_signing"},
     * @OA\Property(property="id_asesi", type="string", example="ASESI2025XXXXX"),
     * @OA\Property(property="umpan_balik", type="array", @OA\Items(type="object",
     * @OA\Property(property="komponen_id", type="integer", example=1),
     * @OA\Property(property="hasil", type="string", example="ya", enum={"ya", "tidak"}),
     * @OA\Property(property="catatan", type="string", example="Sangat membantu.")
     * )),
     * @OA\Property(property="is_signing", type="boolean", example=true, description="Set true untuk menandatangani")
     * )
     * ),
     * @OA\Response(response=200, description="Data AK03 berhasil disimpan"),
     * @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function saveAk03Asesi(Request $request)
    {
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
                $ak03->save();

                // Hapus item lama dan buat yang baru
                $ak03->umpanBalikItems()->delete();
                foreach ($validated['umpan_balik'] as $item) {
                    $ak03->umpanBalikItems()->create($item);
                }

                if ($validated['is_signing']) {
                    $this->progressService->completeStep(
                        $validated['id_asesi'],
                        'ak03',
                        'Completed by Asesi at ' . Carbon::now()->format('d-m-Y H:i:s')
                    );
                    Log::info('AK03 completed by Asesi', ['id_asesi' => $validated['id_asesi']]);
                }
            });
        } catch (\Exception $e) {
            Log::error('Failed to save AK03 data', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Umpan Balik berhasil disimpan.',
        ]);
    }
}
