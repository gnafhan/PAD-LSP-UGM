<?php

namespace App\Http\Controllers;

use App\Models\Fria07;
use App\Models\RincianAsesmen;
use App\Models\UK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class IA07Controller extends Controller
{
    public function index()
    {
        // Get current asesor from authenticated user
        $currentAsesor = auth()->user()->asesor;
        
        if (!$currentAsesor) {
            return redirect()->route('home-asesor')->with('error', 'Data asesor tidak ditemukan');
        }

        // Get daftar asesi untuk asesor yang sedang login
        $daftarAsesi = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])->where('id_asesor', $currentAsesor->id_asesor)->get();

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
                // Load unit kompetensi untuk skema
                if ($detailRincian->asesi && $detailRincian->asesi->skema) {
                    $idArray = is_array($detailRincian->asesi->skema->daftar_id_uk) 
                        ? $detailRincian->asesi->skema->daftar_id_uk 
                        : json_decode($detailRincian->asesi->skema->daftar_id_uk, true);

                    if ($idArray) {
                        $unitKompetensi = UK::with('elemen_uk')->whereIn('id_uk', $idArray)->get();
                        $detailRincian->asesi->skema->unitKompetensiLoaded = $unitKompetensi;
                    }
                }

                // Load FRIA07 data if exists
                $fria07Data = \App\Models\Fria07::where('id_asesi', request('id_asesi'))
                    ->where('id_asesor', $currentAsesor->id_asesor)
                    ->first();
                
                // Attach FRIA07 data to detailRincian object
                if ($fria07Data) {
                    $detailRincian->setAttribute('fria07', $fria07Data);
                }
                    
                // Get existing FRIA07 data
                $formData = \App\Models\Fria07::where('id_asesi', request('id_asesi'))
                    ->where('id_asesor', $detailRincian->id_asesor)
                    ->where('id_skema', $detailRincian->asesi->id_skema)
                    ->first();
                    
                if ($formData) {
                    $isAsesorSigned = $formData->isAsesorSigned();
                    $isAsesiSigned = $formData->isAsesiSigned();
                }
            }
        }

        return view('home.home-asesor.fria07-asesor', compact('daftarAsesi', 'detailRincian', 'notFound', 'formData', 'isAsesorSigned', 'isAsesiSigned'));
    }
    
    public function generatePdf($id_asesi)
    {
        $detailRincian = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])->where('id_asesi', $id_asesi)->first();
        
        if (!$detailRincian) {
            return redirect()->route('fria07-asesor')->with('error', 'Data asesi tidak ditemukan');
        }
        
        if ($detailRincian->asesi && $detailRincian->asesi->skema) {
            $idArray = is_array($detailRincian->asesi->skema->daftar_id_uk) 
                ? $detailRincian->asesi->skema->daftar_id_uk 
                : json_decode($detailRincian->asesi->skema->daftar_id_uk, true);
            
            $detailRincian->asesi->skema->unitKompetensiLoaded = \App\Models\UK::with('elemen_uk')
                ->whereIn('id_uk', $idArray ?? [])
                ->get();
        }
        
        // Get existing FRIA07 data
        $formData = Fria07::where('id_asesi', $id_asesi)
            ->where('id_asesor', $detailRincian->id_asesor)
            ->where('id_skema', $detailRincian->asesi->id_skema)
            ->first();
            
        return view('home.home-asesor.fria07-pdf', compact('detailRincian', 'formData'));
    }
}
