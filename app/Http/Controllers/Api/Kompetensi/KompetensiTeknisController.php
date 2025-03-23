<?php

namespace App\Http\Controllers\Api\Kompetensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesor;
use Illuminate\Support\Facades\Validator;
use App\Models\KompetensiTeknis;


class KompetensiTeknisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        // Cari data Asesor berdasarkan ID
        $asesor = Asesor::with('kompetensiTeknis')->find($id);

        if (!$asesor) {
            return response()->json([
                'success' => false,
                'message' => 'Data Asesor tidak ditemukan'
            ], 404);
        }

        // Ambil jumlah sertifikasi yang diambil oleh asesor
        $jumlahSkema = $asesor->kompetensiTeknis()->count();

        // Ambil daftar ID kompetensi teknis yang dimiliki oleh asesor
        $daftarIdKompetensiTeknis = $asesor->kompetensiTeknis()->pluck('id_kompetensi_teknis');

        return response()->json([
            'success' => true,
            'message' => 'Data Asesor ditemukan',
            'data' => [
                'nama_asesor' => $asesor->nama_asesor,
                'masa_berlaku' => $asesor->masa_berlaku,
                'no_sertifikat' => $asesor->no_sertifikat,
                'jumlah_skema' => $jumlahSkema,
                'status_asesor' => $asesor->status_asesor,
                'file_sertifikat_asesor' => $asesor->file_sertifikat_asesor,
                'daftar_id_kompetensi_teknis' => $daftarIdKompetensiTeknis
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage. DIPAKAI OLEH ADMIN
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_asesor'             => 'required|exists:asesor,id_asesor',
            'lembaga_sertifikasi'   => 'required|string|max:60',
            'skema_kompetensi'      => 'required|string|max:60',
            'masa_berlaku'          => 'required|date',
            'file_sertifikat'       => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // Jika validasi gagal, kirim respons error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Simpan file sertifikat jika ada
        $path = null;
        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $path = $file->store('sertifikat_asesor', 'public'); // Simpan ke storage/public/sertifikat_asesor
        }

        // Simpan data ke database
        try {
            $kompetensiTeknis = KompetensiTeknis::create([
                'id_asesor'             => $request->id_asesor,
                'lembaga_sertifikasi'   => $request->lembaga_sertifikasi,
                'skema_kompetensi'      => $request->skema_kompetensi,
                'masa_berlaku'          => $request->masa_berlaku,
                'file_sertifikat'       => $path,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Kompetensi Teknis berhasil disimpan',
                'data'    => $kompetensiTeknis
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error'   => $e->getMessage()
            ], 500);
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
