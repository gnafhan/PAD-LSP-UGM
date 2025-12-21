<?php

namespace App\Http\Controllers;

use App\Models\Fria01;
use App\Models\RincianAsesmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class IA01Controller extends Controller
{
    public function index()
    {
        $daftarAsesi = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])
        ->whereHas('asesi') // Only get records where asesi exists
        ->get();

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
                // Get existing FRIA01 data
                $formData = Fria01::where('id_asesi', request('id_asesi'))
                    ->where('id_asesor', $detailRincian->id_asesor)
                    ->where('id_skema', $detailRincian->asesi->id_skema)
                    ->first();
            }
        }

        return view('home.home-asesor.fria01-asesor', compact('daftarAsesi', 'detailRincian', 'notFound', 'formData', 'isAsesorSigned', 'isAsesiSigned'));
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
            return redirect()->route('fria01-asesor')->with('error', 'Data asesi tidak ditemukan');
        }
        
        if ($detailRincian->asesi && $detailRincian->asesi->skema) {
            $idArray = is_array($detailRincian->asesi->skema->daftar_id_uk) 
                ? $detailRincian->asesi->skema->daftar_id_uk 
                : json_decode($detailRincian->asesi->skema->daftar_id_uk, true);
            
            $detailRincian->asesi->skema->unitKompetensiLoaded = \App\Models\UK::with('elemen_uk')
                ->whereIn('id_uk', $idArray ?? [])
                ->get();
        }
        
        // Get existing FRIA01 data
        $formData = Fria01::where('id_asesi', $id_asesi)
            ->where('id_asesor', $detailRincian->id_asesor)
            ->where('id_skema', $detailRincian->asesi->id_skema)
            ->first();
            
        return view('home.home-asesor.fria01-pdf', compact('detailRincian', 'formData'));
    }
}
