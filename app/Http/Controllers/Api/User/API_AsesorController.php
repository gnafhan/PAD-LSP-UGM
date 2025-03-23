<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesor;
use Illuminate\Support\Facades\Storage;


class API_AsesorController extends Controller
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
        ], [
            'nama_asesor.required'            => 'Nama Asesor harus diisi',
            'no_sertifikat.required'          => 'Nomor Sertifikat harus diisi',
            'no_hp.required'                  => 'Nomor HP harus diisi',
            'email.required'                  => 'Email harus diisi',
            'alamat.required'                 => 'Alamat harus diisi',
            'bidang.required'                 => 'Bidang harus diisi',
            'gelar_depan.required'            => 'Gelar Depan harus diisi',
            'gelar_belakang.required'         => 'Gelar Belakang harus diisi',
            'no_ktp.required'                 => 'Nomor KTP harus diisi',
            'jenis_kelamin.required'          => 'Jenis Kelamin harus diisi',
            'pendidikan_terakhir.required'    => 'Pendidikan Terakhir harus diisi',
            'keahlian.required'               => 'Keahlian harus diisi',
            'tempat_lahir.required'           => 'Tempat Lahir harus diisi',
            'tanggal_lahir.required'          => 'Tanggal Lahir harus diisi',
            'kebangsaan.required'             => 'Kebangsaan harus diisi',
            'no_lisensi.required'             => 'Nomor Lisensi harus diisi',
            'institusi_asal.required'         => 'Institusi Asal harus diisi',
            'no_telp_institusi_asal.required' => 'Nomor Telepon Institusi Asal harus diisi',
            'fax_institusi_asal.required'     => 'Fax Institusi Asal harus diisi',
            'email_institusi_asal.required'   => 'Email Institusi Asal harus diisi',
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

        // Proses penyimpanan file gambar jika ada
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

        // Simpan update ke database dengan error handling
        try {
            $asesor->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Data Asesor berhasil diupdate',
                'data'    => $asesor->refresh() // refresh untuk mendapatkan data terbaru
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show_biodata(string $id)
    {
        // Cari data Asesor berdasarkan ID
        $asesor = Asesor::find($id);
        if (!$asesor) {
            return response()->json([
                'success' => false,
                'message' => 'Data Asesor tidak ditemukan'
            ], 404);
        }
        
        // Jika data ditemukan, kembalikan response dengan data Asesor
        return response()->json([
            'success' => true,
            'message' => 'Data Asesor ditemukan',
            'data'    => $asesor
        ], 200);
    }   
}
