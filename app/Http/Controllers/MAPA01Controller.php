<?php

namespace App\Http\Controllers;

use App\Helpers\DateTimeHelper;
use App\Models\Ak07;
use App\Models\Ak07SeederA;
use App\Models\Ak07SeederB;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\Mapa01;
use App\Models\PotensiAsesi;
use App\Models\RencanaAsesmen;
use App\Models\RincianAsesmen;

class MAPA01Controller extends Controller
{
    public function generatePdf($id_asesi)
    {
        $asesi = Asesi::findOrFail($id_asesi);
        $asesi->load(['skema', 'rincianAsesmen.event.tuk']);

        if (!$asesi) {
            return redirect()->route('frmapa01-asesor')->with('error', 'Data asesi tidak ditemukan');
        }

        $detailRincian = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])->where('id_asesi', $id_asesi)->first();

        $asesor = Asesor::find($detailRincian->id_asesor);

        if (!$detailRincian) {
            return redirect()->route('frak07-asesor')->with('error', 'Data asesi tidak ditemukan');
        }

        $mapa01 = Mapa01::where('id_asesi', $id_asesi)
            ->where('id_asesor', $asesor->id_asesor)
            ->first();

//        @dd($asesi);

        // Get rencana asesmen data
        $allRencanaAsesmen = RencanaAsesmen::where('id_skema', $asesi->skema->nomor_skema)
            ->with('unitKompetensi')
            ->get();

//        @dd($allRencanaAsesmen);

        $generalInfo = [
            'nama_asesi' => $asesi->nama_asesi,
            'nama_asesor' => $asesor->nama_asesor,
            'nama_tuk' => $asesi->rincianAsesmen->event->tuk->nama_tuk,
            'judul_skema' => $asesi->skema->nama_skema,
            'kode_skema' => $asesi->skema->nomor_skema,
            'pelaksanaan_asesmen_disepakati_mulai' => $asesi->created_at->format('d-m-Y')
        ];
//        @dd($generalInfo);

        // Check if the AK07 record exists
        if ($mapa01) {
            // Check if the asesor has a valid signature
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($mapa01->waktu_tanda_tangan_asesor);
            if ($tandaTanganAsesor) {
                $tandaTanganAsesor->file_url = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }

            // Retrieve hasil items
            $hasilItems = $mapa01->hasilItems()->pluck('hasil_item')->toArray();

            return view('home.home-asesor.frmapa01-pdf', [
                'generalInfo' => $generalInfo,
                'mapa01' => [
                    'hasil_yang_akan_dikumpulkan' => $hasilItems,
                    'waktu_tanda_tangan_asesi' => DateTimeHelper::toWIB($mapa01->waktu_tanda_tangan_asesi),
                    'tanda_tangan_asesi' => $mapa01->waktu_tanda_tangan_asesi ? $asesi->ttd_pemohon = asset('storage/' . $asesi->ttd_pemohon) : null,
                    'waktu_tanda_tangan_asesor' => DateTimeHelper::toWIB($mapa01->waktu_tanda_tangan_asesor),
                    'tanda_tangan_asesor' => $tandaTanganAsesor ? $tandaTanganAsesor->file_url : null,
                ],
                'record_exists' => true
            ]);

        } else {
            // Record doesn't exist - provide only general information
            return view('home.home-asesor.mapa01-pdf', [
                'generalInfo' => $generalInfo,
                'record_exists' => false
            ]);
        }
    }
}
