<?php

namespace App\Http\Controllers\Api\Kompetensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesor;
use Illuminate\Support\Facades\Validator;
use App\Models\KompetensiTeknis;

/**
 * @OA\Tag(
 *     name="Asesor",
 *     description="API Endpoints untuk pengelolaan kompetensi teknis asesor"
 * )
 */
class KompetensiTeknisController extends Controller
{
        /**
     * Get data kompetensi teknis asesor
     *
     * @OA\Get(
     *     path="/asesor/kompetensi_teknis/{id}",
     *     summary="Mendapatkan data kompetensi teknis asesor",
     *     tags={"Kompetensi Teknis"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID asesor",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data asesor ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data Asesor ditemukan"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="asesor", type="object",
     *                     @OA\Property(property="id_asesor", type="string", example="1"),
     *                     @OA\Property(property="nama_asesor", type="string", example="John Doe"),
     *                     @OA\Property(property="masa_berlaku", type="string", example="01-01-2025"),
     *                     @OA\Property(property="no_met", type="string", example="MET123456"),
     *                     @OA\Property(property="jumlah_skema", type="integer", example=3),
     *                     @OA\Property(property="status_asesor", type="string", example="Aktif"),
     *                     @OA\Property(property="file_url_sertifikat_bnsp", type="string", example="/storage/sertifikat_asesor/asesor_5LLZtmcxXl_1750085296.pdf"),
     *                     @OA\Property(property="file_url_foto_asesor", type="string", example="/storage/data_asesor/5LLZtmcxXl_1750085296.pdf")
     *                 ),
     *                 @OA\Property(property="kompetensi_teknis", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id_kompetensi_teknis", type="string", example="1"),
     *                         @OA\Property(property="lembaga_sertifikasi", type="string", example="LSP UGM"),
     *                         @OA\Property(property="skema_kompetensi", type="string", example="Software Developer"),
     *                         @OA\Property(property="masa_berlaku", type="string", example="01-01-2025"),
     *                         @OA\Property(property="file_sertifikat", type="string", example="cert_teknis123.pdf"),
     *                         @OA\Property(property="file_url", type="string", example="http://localhost/storage/sertifikat/cert_teknis123.pdf")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data asesor tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data Asesor tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function index(string $id)
    {
        // Cari data Asesor berdasarkan ID dengan eager loading kompetensiTeknis
        $asesor = Asesor::with('kompetensiTeknis')->find($id);

        if (!$asesor) {
            return response()->json([
                'success' => false,
                'message' => 'Data Asesor tidak ditemukan'
            ], 404);
        }

        // Ambil jumlah sertifikasi yang diambil oleh asesor
        $jumlahSkema = $asesor->kompetensiTeknis()->count();

        // Transform kompetensi teknis untuk format yang lebih sesuai
        $kompetensiTeknis = $asesor->kompetensiTeknis->map(function($item) {
            return [
                'id_kompetensi_teknis' => $item->id_kompetensi_teknis,
                'lembaga_sertifikasi' => $item->lembaga_sertifikasi,
                'skema_kompetensi' => $item->skema_kompetensi,
                'masa_berlaku' => $this->formatTanggal($item->masa_berlaku),
                'file_sertifikat' => $item->file_sertifikat,
                'file_url' => asset('storage/sertifikat_kompetensi/' . $item->file_sertifikat)
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data Asesor ditemukan',
            'data' => [
                'asesor' => [
                    'id_asesor' => $asesor->id_asesor,
                    'nama_asesor' => $asesor->nama_asesor,
                    'masa_berlaku' => $this->formatTanggal($asesor->masa_berlaku), // Gunakan formatTanggal di sini
                    'no_met' => $asesor->no_met,
                    'jumlah_skema' => $jumlahSkema,
                    'status_asesor' => $asesor->status_asesor,
                    'file_url_sertifikat_bnsp' => asset('storage/sertifikat_asesor/' . $asesor->file_sertifikat_asesor),
                    'file_url_foto_asesor' => asset('storage/data_asesor/' . $asesor->foto_asesor),

                ],
                'kompetensi_teknis' => $kompetensiTeknis
            ],
        ], 200);
    }

    /**
     * Format tanggal dengan penanganan berbagai tipe data
     *
     * @param mixed $tanggal
     * @return string
     */
    private function formatTanggal($tanggal)
    {
        if (empty($tanggal)) {
            return '';
        }

        if ($tanggal instanceof \Carbon\Carbon) {
            return $tanggal->format('d-m-Y');
        }

        // Coba convert string ke carbon
        try {
            return \Carbon\Carbon::parse($tanggal)->format('d-m-Y');
        } catch (\Exception $e) {
            // Jika parsing gagal, kembalikan data asli
            return $tanggal;
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
