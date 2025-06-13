<?php

namespace App\Http\Controllers\Api\DataUser;

use App\Http\Controllers\Controller;
use App\Models\KompetensiTeknis;
use App\Models\RincianAsesmen;
use Illuminate\Http\Request;
use App\Models\Asesor;
use Illuminate\Support\Facades\Storage;
use App\Models\TandaTanganAsesor;
use Illuminate\Support\Facades\DB;


/**
 * @OA\Tag(
 *     name="Asesor",
 *     description="API Endpoints untuk pengelolaan data Asesor"
 * )
 */
class DataAsesorController extends Controller
{

    /**
     * Update biodata asesor
     *
     * @OA\Post(
     *     path="/asesor/biodata/{id}",
     *     summary="Update data asesor",
     *     tags={"Asesor"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID asesor",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"_method", "nama_asesor", "no_sertifikat", "no_hp", "alamat", "no_ktp",
     *                           "jenis_kelamin", "kebangsaan", "no_met", "kode_pos"},
     *                 @OA\Property(
     *                     property="_method",
     *                     type="string",
     *                     default="PUT",
     *                     description="Method spoofing untuk Laravel"
     *                 ),
     *                 @OA\Property(property="nama_asesor", type="string", example="John Doe"),
     *                 @OA\Property(property="no_sertifikat", type="string", example="CERT123456"),
     *                 @OA\Property(property="no_hp", type="string", example="081234567890"),
     *                 @OA\Property(property="alamat", type="string", example="Jl. Contoh No. 123"),
     *                 @OA\Property(property="no_ktp", type="string", example="3301012345678901"),
     *                 @OA\Property(property="jenis_kelamin", type="string", example="Laki-laki"),
     *                 @OA\Property(property="kebangsaan", type="string", example="Indonesia"),
     *                 @OA\Property(property="no_met", type="string", example="MET12345"),
     *                 @OA\Property(property="kode_pos", type="string", example="12345"),
     *                 @OA\Property(property="kode_registrasi", type="string", example="REG-2025-001"),
     *                 @OA\Property(
     *                     property="tanda_tangan",
     *                     description="File tanda tangan",
     *                     type="file",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="foto_asesor",
     *                     description="Foto asesor",
     *                     type="file",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data asesor berhasil diupdate",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data Asesor berhasil diupdate"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data asesor tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data Asesor tidak ditemukan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validasi gagal"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update_biodata(Request $request, string $id)
    {
        // Lakukan validasi menggunakan Validator
        $validator = \Validator::make($request->all(), [
            'nama_asesor'               => 'required|string|max:255',
            'no_sertifikat'             => 'required|string|max:30',
            'no_hp'                     => 'required|string|max:20',
            'no_met'                    => 'nullable|string|max:100',
            'alamat'                    => 'required|string',
            'no_ktp'                    => 'required|string|max:20',
            'jenis_kelamin'             => 'required|string|in:Laki-laki,Perempuan',
            'kebangsaan'                => 'required|string|max:30',
            'kode_pos'                  => 'nullable|string|max:30',
            'kode_registrasi'           => 'nullable|string|max:30',
            'tanda_tangan'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_asesor'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika validasi gagal, kembalikan error response dengan status code 422
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Cari data Asesor berdasarkan $id
        $asesor = Asesor::find($id);
        if (!$asesor) {
            return response()->json([
                'success' => false,
                'message' => 'Data Asesor tidak ditemukan'
            ], 404);
        }

        // Persiapkan data update dari request
        $data = [
            'nama_asesor'               => $request->nama_asesor,
            'no_sertifikat'             => $request->no_sertifikat,
            'no_hp'                     => $request->no_hp,
            'no_met'                    => $request->no_met,
            'alamat'                    => $request->alamat,
            'no_ktp'                    => $request->no_ktp,
            'jenis_kelamin'             => $request->jenis_kelamin,
            'kebangsaan'                => $request->kebangsaan,
            'kode_pos'                  => $request->kode_pos,
            'kode_registrasi'           => $request->kode_registrasi,
        ];

        // Simpan update ke database dengan error handling dan transaction
        DB::beginTransaction();
        try {
            // Proses penyimpanan file foto jika ada
            if ($request->hasFile('foto_asesor')) {
                // Jika data Asesor sudah memiliki foto, hapus file lama terlebih dahulu
                if (!empty($asesor->foto_asesor)) {
                    $oldPath = 'data_asesor/' . $asesor->foto_asesor;
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                // Simpan file baru dan update path-nya
                $file = $request->file('foto_asesor');
                $path = $file->store('data_asesor', 'public');
                $data['foto_asesor'] = basename($path);
            }

            // Update data asesor
            $asesor->update($data);

            // Proses tanda tangan jika ada
            if ($request->hasFile('tanda_tangan')) {

                // Nonaktifkan tanda tangan aktif yang ada
                TandaTanganAsesor::where('id_asesor', $id)
                    ->whereNull('valid_until')
                    ->update(['valid_until' => now()]);

                // Simpan tanda tangan baru
                $fileTandaTangan = $request->file('tanda_tangan');
                $pathTandaTangan = $fileTandaTangan->store('tanda_tangan', 'public');

                TandaTanganAsesor::create([
                    'id_asesor' => $id,
                    'file_tanda_tangan' => basename($pathTandaTangan),
                    'valid_from' => now(),
                ]);
            }

            DB::commit();

            // Load asesor dengan tanda tangan aktif
            $asesor->refresh();
            $asesor->load('tandaTanganAktif');

            return response()->json([
                'success' => true,
                'message' => 'Data Asesor berhasil diupdate',
                'data'    => $asesor
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Show biodata asesor
     *
     * @OA\Get(
     *     path="/asesor/biodata/{id}",
     *     summary="Mendapatkan data biodata asesor",
     *     tags={"Asesor"},
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
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
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
    public function show_biodata(string $id)
    {
        $asesor = Asesor::with('tandaTanganAktif')->find($id);
        if (!$asesor) {
            return response()->json([
                'success' => false,
                'message' => 'Data Asesor tidak ditemukan'
            ], 404);
        }

        // Accessor for daftar_bidang_kompetensi will automatically convert IDs to names
        // when $asesor is serialized to JSON.
        // The tandaTanganAktif relation also needs its file_url if present.
        if ($asesor->tandaTanganAktif->isNotEmpty()) {
            $tandaTangan = $asesor->tandaTanganAktif->first();
            $asesor->file_url_tanda_tangan = asset('storage/tanda_tangan/' . $tandaTangan->file_tanda_tangan);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Asesor ditemukan',
            'data'    => $asesor->makeHidden(['created_at', 'updated_at', 'tanda_tangan']),
        ], 200);
    }

    /**
     * Get data asesor for dashboard page
     *
     * @OA\Get(
     *     path="/asesor/dashboard/{id}",
     *     summary="Mendapatkan data dashboard asesor",
     *     tags={"Asesor"},
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
     *                  @OA\Property(property="nama_asesor", type="string", example="John Doe"),
     *                  @OA\Property(property="email_asesor", type="string", example="john@example.com"),
     *                  @OA\Property(property="jumlah_asesi", type="integer", example=10),
     *                  @OA\Property(property="jumlah_event", type="integer", example=5),
     *                  @OA\Property(property="jumlah_skema", type="integer", example=3),
     *                  @OA\Property(property="jumlah_kompetensi_teknis", type="integer", example=4)
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
    public function dashboard_asesor(string $id){
        $asesor = Asesor::where('id_asesor', $id)->first();

        if ($asesor){
            $jumlahAsesi = RincianAsesmen::where('id_asesor', $id)->count();
            $jumlahEvent = RincianAsesmen::where('id_asesor', $id)->distinct('id_event')->count('id_event');
            $jumlahSkema = DB::table('rincian_asesmen')
                ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
                ->where('rincian_asesmen.id_asesor', $id)
                ->distinct('asesi.id_skema')
                ->count('asesi.id_skema');
            $jumlahKompetensiTeknis = KompetensiTeknis::where('id_asesor', $id)->count();

            return response()->json([
                'success' => true,
                'message' => 'Data Asesor ditemukan',
                'data'    => [
                    'nama_asesor' => $asesor->nama_asesor,
                    'email_asesor' => $asesor->email,
                    'jumlah_asesi' => $jumlahAsesi,
                    'jumlah_event' => $jumlahEvent,
                    'jumlah_skema' => $jumlahSkema,
                    'jumlah_kompetensi_teknis' => $jumlahKompetensiTeknis
                ]
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Data Asesor tidak ditemukan'
        ], 404);
    }
}
