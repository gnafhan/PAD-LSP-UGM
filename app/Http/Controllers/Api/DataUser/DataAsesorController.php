<?php

namespace App\Http\Controllers\Api\DataUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesor;
use Illuminate\Support\Facades\Storage;
use App\Models\TandaTanganAsesor;
use Illuminate\Support\Facades\DB;



class DataAsesorController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function show_asesor()
    {
        // Ambil data asesor dengan paginasi, default 20 per halaman
        $asesors = Asesor::latest()->paginate(20);

        // Cek apakah ada data
        if ($asesors->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data asesor tidak ditemukan',
                'data' => []
            ], 404); // Status Code 404 Not Found
        }

        return response()->json([
            'success' => true,
            'message' => 'Data asesor berhasil diambil',
            'data' => $asesors
        ], 200); // Status Code 200 OK
    }

    /**
     * Store a updated asesor's data resource in storage.
     */
    public function update_biodata(Request $request, string $id)
    {
        // Lakukan validasi menggunakan Validator
        $validator = \Validator::make($request->all(), [
            'nama_asesor'               => 'required|string|max:255',
            'no_sertifikat'             => 'required|string|max:255',
            'no_hp'                     => 'required|string|max:20',
            'email'                     => 'required|email|max:255',
            'alamat'                    => 'required|string|max:255',
            'bidang'                    => 'required|string|max:255',
            'gelar_depan'               => 'required|string|max:255',
            'gelar_belakang'            => 'required|string|max:255',
            'no_ktp'                    => 'required|string|max:20',
            'jenis_kelamin'             => 'required|string|in:Laki-laki,Perempuan',
            'pendidikan_terakhir'       => 'required|string|max:255',
            'keahlian'                  => 'required|string|max:255',
            'tempat_lahir'              => 'required|string|max:255',
            'tanggal_lahir'             => 'required|date',
            'kebangsaan'                => 'required|string|max:255',
            'no_lisensi'                => 'required|string|max:255',
            'institusi_asal'            => 'required|string|max:255',
            'no_telp_institusi_asal'    => 'required|string|max:20',
            'fax_institusi_asal'        => 'required|string|max:20',
            'email_institusi_asal'      => 'required|email|max:255',
            'tanda_tangan'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // ...existing validation messages...
            'tanda_tangan.image'        => 'File tanda tangan harus berupa gambar',
            'tanda_tangan.mimes'        => 'Format tanda tangan harus jpeg, png, jpg, atau gif',
            'tanda_tangan.max'          => 'Ukuran tanda tangan maksimal 2MB',
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
            'email'                     => $request->email,
            'alamat'                    => $request->alamat,
            'bidang'                    => $request->bidang,
            'gelar_depan'               => $request->gelar_depan,
            'gelar_belakang'            => $request->gelar_belakang,
            'no_ktp'                    => $request->no_ktp,
            'jenis_kelamin'             => $request->jenis_kelamin,
            'pendidikan_terakhir'       => $request->pendidikan_terakhir,
            'keahlian'                  => $request->keahlian,
            'tempat_lahir'              => $request->tempat_lahir,
            'tanggal_lahir'             => $request->tanggal_lahir,
            'kebangsaan'                => $request->kebangsaan,
            'no_lisensi'                => $request->no_lisensi,
            'institusi_asal'            => $request->institusi_asal,
            'no_telp_institusi_asal'    => $request->no_telp_institusi_asal,
            'fax_institusi_asal'        => $request->fax_institusi_asal,
            'email_institusi_asal'      => $request->email_institusi_asal,
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

    public function show_biodata(string $id)
    {
        // Cari data Asesor berdasarkan ID dengan tanda tangan aktif
        $asesor = Asesor::with('tandaTanganAktif')->find($id);
        if (!$asesor) {
            return response()->json([
                'success' => false,
                'message' => 'Data Asesor tidak ditemukan'
            ], 404);
        }
        
        // Tambahkan URL untuk tanda tangan aktif jika ada
        if ($asesor->tandaTanganAktif->isNotEmpty()) {
            $tandaTangan = $asesor->tandaTanganAktif->first();
            $tandaTangan->file_url = asset('storage/tanda_tangan/' . $tandaTangan->file_tanda_tangan);
        }
        
        // Jika data ditemukan, kembalikan response dengan data Asesor
        return response()->json([
            'success' => true,
            'message' => 'Data Asesor ditemukan',
            'data'    => $asesor
        ], 200);
    }
}
