<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use App\Models\JawabanBanding;
use App\Models\PertanyaanBanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AK04Controller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $asesi = Asesi::where('id_user', $user->id_user)->first();

        $asesi = DB::table('asesi')
            ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
            ->join('rincian_asesmen', 'asesi.id_asesi', '=', 'rincian_asesmen.id_asesi')
            ->join('event', 'rincian_asesmen.id_event', '=', 'event.id_event')
            ->join('tuk', 'event.id_tuk', '=', 'tuk.id_tuk')
            ->join('asesor', 'rincian_asesmen.id_asesor', '=', 'asesor.id_asesor')
            ->where('asesi.id_asesi', $asesi->id_asesi)
            ->select('asesi.id_asesi', 'asesi.nama_asesi', 'skema.nama_skema', 'skema.nomor_skema', 'tuk.nama_tuk', 'asesor.nama_asesor', 'asesor.id_asesor', 'rincian_asesmen.id_rincian_asesmen')
            ->first();

        // get pertanyaan banding sort by order
        $pertanyaan_banding = PertanyaanBanding::orderBy('order', 'asc')->get();

        $jawaban_banding = JawabanBanding::where('id_rincian_asesmen', $asesi->id_rincian_asesmen)->get();

        return view('home/home-asesi/FRAK-04/frak4', compact(['asesi', 'pertanyaan_banding', 'jawaban_banding']));
    }
    /**
     * Store a new banding submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBanding(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'jawaban' => 'required|array',
                'jawaban.*' => 'required|string',
            ]);

            $user = Auth::user();
            $asesi = Asesi::where('id_user', $user->id_user)->first();

            if (!$asesi) {
                return redirect()->back()->with('error', 'Data asesi tidak ditemukan.');
            }

            // Ambil data asesi lengkap dengan rincian asesmen
            $asesi_detail = DB::table('asesi')
                ->join('rincian_asesmen', 'asesi.id_asesi', '=', 'rincian_asesmen.id_asesi')
                ->where('asesi.id_asesi', $asesi->id_asesi)
                ->select('rincian_asesmen.id_rincian_asesmen')
                ->first();

            if (!$asesi_detail) {
                return redirect()->back()->with('error', 'Data rincian asesmen tidak ditemukan.');
            }

            // Loop untuk menyimpan jawaban
            foreach ($request->jawaban as $id_pertanyaan => $jawaban) {
                // Cek apakah jawaban sudah ada
                $existing_jawaban = JawabanBanding::where('id_pertanyaan_banding', $id_pertanyaan)
                    ->where('id_rincian_asesmen', $asesi_detail->id_rincian_asesmen)
                    ->first();

                if ($existing_jawaban) {
                    // Update jawaban yang sudah ada
                    $existing_jawaban->update([
                        'jawaban' => $jawaban,
                        'updated_at' => now()
                    ]);
                } else {
                    // Buat jawaban baru
                    JawabanBanding::create([
                        'id_pertanyaan_banding' => $id_pertanyaan,
                        'id_rincian_asesmen' => $asesi_detail->id_rincian_asesmen,
                        'jawaban' => $jawaban,
                    ]);
                }
            }

            return redirect()->route('asesi.index')->with('success', 'Jawaban banding berhasil disimpan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
