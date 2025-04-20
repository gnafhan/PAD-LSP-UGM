<?php

namespace App\Http\Controllers\Api\Kompetensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asesor;
use Illuminate\Support\Facades\Validator;
use App\Models\KompetensiTeknis;


class KompetensiTeknisController extends Controller
{
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
                'file_url' => asset('storage/sertifikat/' . $item->file_sertifikat)
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
                    'no_sertifikat' => $asesor->no_sertifikat,
                    'jumlah_skema' => $jumlahSkema,
                    'status_asesor' => $asesor->status_asesor,
                    'file_sertifikat' => $asesor->file_sertifikat_asesor,
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
