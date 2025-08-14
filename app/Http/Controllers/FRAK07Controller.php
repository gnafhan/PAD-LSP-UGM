<?php

namespace App\Http\Controllers;

use App\Helpers\DateTimeHelper;
use App\Models\Ak07;
use App\Models\Ak07SeederA;
use App\Models\Ak07SeederB;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\PotensiAsesi;
use App\Models\RincianAsesmen;

class FRAK07Controller extends Controller
{
    public function generatePdf($id_asesi)
    {
        $asesi = Asesi::findOrFail($id_asesi);
        $asesi->load(['skema', 'rincianAsesmen.event.tuk']);

        if (!$asesi) {
            return redirect()->route('frak07-asesor')->with('error', 'Data asesi tidak ditemukan');
        }

        $detailRincian = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])->where('id_asesi', $id_asesi)->first();

//        @dd($detailRincian);

        $asesor = Asesor::find($detailRincian->id_asesor);

//        @dd($asesor);

        if (!$detailRincian) {
            return redirect()->route('frak07-asesor')->with('error', 'Data asesi tidak ditemukan');
        }

        $ak07 = Ak07::where('id_asesi', $asesi->id_asesi)
            ->first();

        $generalInfo = [
            'nama_asesi' => $asesi->nama_asesi,
            'nama_asesor' => $asesor->nama_asesor,
            'nama_tuk' => $asesi->rincianAsesmen->event->tuk->nama_tuk,
            'judul_skema' => $asesi->skema->nama_skema,
            'kode_skema' => $asesi->skema->nomor_skema,
            'pelaksanaan_asesmen_disepakati_mulai' => $asesi->created_at->format('d-m-Y')
        ];
//        @dd($generalInfo);

        // seeder a dan b + potensi
        $seederA = Ak07SeederA::all();
        $seederB = Ak07SeederB::all();
        $potensiAsesi = PotensiAsesi::all();


        // Check if the AK07 record exists
        if ($ak07) {
            // Check if the asesor has a valid signature
            $tandaTanganAsesor = $asesor->getTandaTanganPadaWaktu($ak07->waktu_tanda_tangan_asesor);
            if ($tandaTanganAsesor) {
                $tandaTanganAsesor->file_url = asset('storage/tanda_tangan/' . $tandaTanganAsesor->file_tanda_tangan);
            }

            // Retrieve hasil items
            $hasilItems = $ak07->hasilItems()->pluck('hasil_item')->toArray();

            // Record exists - return the record data
            $bagianA = $ak07->bagianAs()->get(['item', 'penyesuaian']);
            $bagianB = $ak07->bagianBs()->get(['item', 'penyesuaian', 'lainnya']);


            return view('home.home-asesor.frak07-pdf', [
                'generalInfo' => $generalInfo,
                'seeder_a' => $seederA,
                'seeder_b' => $seederB,
                'potensiAsesi' => $potensiAsesi,
                'ak07' => [
                    'hasil_yang_akan_dikumpulkan' => $hasilItems,
                    'bagian_a' => $bagianA,
                    'bagian_b' => $bagianB,
                    'waktu_tanda_tangan_asesi' => DateTimeHelper::toWIB($ak07->waktu_tanda_tangan_asesi),
                    'tanda_tangan_asesi' => $ak07->waktu_tanda_tangan_asesi ? $asesi->ttd_pemohon = asset('storage/' . $asesi->ttd_pemohon) : null,
                    'waktu_tanda_tangan_asesor' => DateTimeHelper::toWIB($ak07->waktu_tanda_tangan_asesor),
                    'tanda_tangan_asesor' => $tandaTanganAsesor ? $tandaTanganAsesor->file_url : null,
                ],
                'record_exists' => true
            ]);

        } else {
            // Record doesn't exist - provide only general information
            return view('home.home-asesor.frak07-pdf', [
                'generalInfo' => $generalInfo,
                'seeder_a' => $seederA,
                'seeder_b' => $seederB,
                'potensiAsesi' => $potensiAsesi,
                'record_exists' => false
            ]);
        }
    }
}
