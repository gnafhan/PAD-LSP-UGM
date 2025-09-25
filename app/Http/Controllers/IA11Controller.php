<?php

namespace App\Http\Controllers;

use App\Models\IA11;
use App\Models\RincianAsesmen;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class IA11Controller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $asesor = $user->asesor;
        
        if (!$asesor) {
            return redirect()->route('home')->with('error', 'Data asesor tidak ditemukan');
        }

        $daftarAsesi = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])->where('id_asesor', $asesor->id_asesor)->get();

        $detailRincian = null;
        $notFound = false;
        $formData = null;
        $isAsesorSigned = false;
        $isAsesiSigned = false;
        
        if (request()->has('id_asesi')) {
            $detailRincian = $daftarAsesi->where('id_asesi', request('id_asesi'))->first();
            if (!$detailRincian) {
                $notFound = true;
            } else {
                // Get existing IA11 data
                $formData = IA11::where('id_asesi', request('id_asesi'))
                    ->where('id_asesor', $detailRincian->id_asesor)
                    ->where('id_skema', $detailRincian->asesi->id_skema)
                    ->first();
                
                if ($formData) {
                    $isAsesorSigned = $formData->isAsesorSigned();
                    $isAsesiSigned = $formData->isAsesiSigned();
                    
                    // Decode kegiatan_data and merge with formData for easy access
                    if ($formData->kegiatan_data) {
                        $kegiatanData = is_string($formData->kegiatan_data) 
                            ? json_decode($formData->kegiatan_data, true) 
                            : $formData->kegiatan_data;
                        
                        // Merge the answers data into formData for easy access in view
                        foreach ($kegiatanData as $key => $value) {
                            $formData->$key = $value;
                        }
                    }
                }
            }
        }

        return view('home.home-asesor.fria11-asesor', compact('daftarAsesi', 'detailRincian', 'notFound', 'formData', 'isAsesorSigned', 'isAsesiSigned'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'id_skema' => 'required|string|exists:skema,id_skema',
            'komentar_all' => 'nullable|string',
            'is_asesor_signing' => 'nullable|boolean',
        ]);

        $asesi = Asesi::with('skema')->find($request->id_asesi);
        $asesor = Asesor::find($request->id_asesor);

        // Collect answers data
        $answersData = [];
        for ($i = 1; $i <= 8; $i++) {
            $pertanyaan = $request->input("pertanyaan_$i");
            $komentar = $request->input("komentar_$i");
            
            if ($pertanyaan) {
                $answersData["pertanyaan_$i"] = $pertanyaan;
            }
            if ($komentar) {
                $answersData["komentar_$i"] = $komentar;
            }
        }

        $ia11Data = [
            'id_asesi' => $request->id_asesi,
            'id_asesor' => $request->id_asesor,
            'id_skema' => $request->id_skema,
            'judul_sertifikasi' => $asesi->skema->nama_skema ?? '',
            'nama_peserta' => $asesi->nama_asesi ?? '',
            'nama_asesor' => $asesor->nama_asesor ?? '',
            'kegiatan_data' => json_encode($answersData), // Store as JSON
            'komentar_all' => $request->komentar_all,
            'status' => 'draft',
        ];

        // Handle signing
        $isAsesorSigning = filter_var($request->is_asesor_signing, FILTER_VALIDATE_BOOLEAN);
        if ($isAsesorSigning) {
            $ia11Data['waktu_tanda_tangan_asesor'] = now()->toDateTimeString();
            $ia11Data['status'] = 'completed';
            
            // Get asesor signature from tanda_tangan_asesor table
            $tandaTanganAktif = $asesor->tandaTanganAktif()->first();
            if ($tandaTanganAktif) {
                $ia11Data['ttd_asesor'] = $tandaTanganAktif->file_tanda_tangan;
            }
        }

        $ia11 = IA11::updateOrCreate(
            [
                'id_asesi' => $request->id_asesi,
                'id_asesor' => $request->id_asesor,
                'id_skema' => $request->id_skema,
            ],
            $ia11Data
        );

        return redirect()->back()->with('success', 'Data IA11 berhasil disimpan');
    }

    public function sign(Request $request)
    {
        $request->validate([
            'id_asesi' => 'required|string|exists:asesi,id_asesi',
            'id_asesor' => 'required|string|exists:asesor,id_asesor',
            'waktu_tanda_tangan' => 'required|string',
        ]);

        $ia11 = IA11::where('id_asesi', $request->id_asesi)
            ->where('id_asesor', $request->id_asesor)
            ->first();

        if (!$ia11) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data IA11 tidak ditemukan'
            ], 404);
        }

        // Get asesor signature from tanda_tangan_asesor table
        $asesor = Asesor::find($request->id_asesor);
        $signatureFile = null;
        
        if ($asesor) {
            $tandaTanganAktif = $asesor->tandaTanganAktif()->first();
            if ($tandaTanganAktif) {
                $signatureFile = $tandaTanganAktif->file_tanda_tangan;
            }
        }

        $ia11->update([
            'waktu_tanda_tangan_asesor' => $request->waktu_tanda_tangan,
            'ttd_asesor' => $signatureFile,
            'status' => 'completed'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'IA11 berhasil ditandatangani',
            'data' => $ia11
        ]);
    }
}
