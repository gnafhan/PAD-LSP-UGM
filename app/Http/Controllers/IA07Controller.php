<?php

namespace App\Http\Controllers;

use App\Models\Fria07;
use App\Models\IA07Question;
use App\Models\RincianAsesmen;
use App\Models\UK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class IA07Controller extends Controller
{
    public function index()
    {
        $currentAsesor = auth()->user()->asesor;
        
        if (!$currentAsesor) {
            return redirect()->route('home-asesor')->with('error', 'Data asesor tidak ditemukan');
        }

        // Daftar asesi
        $daftarAsesi = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])->where('id_asesor', $currentAsesor->id_asesor)->get();
        
        // Load FRIA07 data untuk setiap asesi
        foreach ($daftarAsesi as $rincian) {
            $fria07 = Fria07::where('id_asesi', $rincian->id_asesi)
                ->where('id_asesor', $currentAsesor->id_asesor)
                ->first();
            $rincian->fria07_data = $fria07;
        }

        $detailRincian = null;
        $notFound = false;
        $formData = null;
        $isAsesorSigned = false;
        $isAsesiSigned = false;
        $schemeQuestions = collect(); // Requirements: 8.3 - Scheme-specific questions
        $hasSchemeQuestions = false; // Requirements: 8.4 - Indicate if content is configured
        
        if (request()->has('id_asesi')) {
            $detailRincian = $daftarAsesi->where('id_asesi', request('id_asesi'))->first();
            if (!$detailRincian) {
                $notFound = true;
            } else {
                // Load unit kompetensi
                if ($detailRincian->asesi && $detailRincian->asesi->skema) {
                    $idArray = is_array($detailRincian->asesi->skema->daftar_id_uk) 
                        ? $detailRincian->asesi->skema->daftar_id_uk 
                        : json_decode($detailRincian->asesi->skema->daftar_id_uk, true);

                    if ($idArray) {
                        $unitKompetensi = UK::with('elemen_uk')->whereIn('id_uk', $idArray)->get();
                        $detailRincian->asesi->skema->unitKompetensiLoaded = $unitKompetensi;
                    }
                    
                    // Requirements: 8.3 - Load scheme-specific oral questions from IA07Question
                    $schemeQuestions = IA07Question::forSkema($detailRincian->asesi->skema->id_skema)
                        ->active()
                        ->ordered()
                        ->with(['unitKompetensi', 'elemenUK'])
                        ->get()
                        ->groupBy('id_uk');
                    
                    // Requirements: 8.4 - Check if scheme has configured questions
                    $hasSchemeQuestions = $schemeQuestions->isNotEmpty();
                }

                // Load FRIA07 data
                $fria07Data = \App\Models\Fria07::where('id_asesi', request('id_asesi'))
                    ->where('id_asesor', $currentAsesor->id_asesor)
                    ->first();
                
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

        return view('home.home-asesor.fria07-asesor', compact(
            'daftarAsesi', 
            'detailRincian', 
            'notFound', 
            'formData', 
            'isAsesorSigned', 
            'isAsesiSigned',
            'schemeQuestions',
            'hasSchemeQuestions'
        ));
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
        
        // Get tanda tangan asesor
        $tandaTanganAsesor = null;
        if ($detailRincian->asesor) {
            $tandaTanganAsesor = \App\Models\TandaTanganAsesor::where('id_asesor', $detailRincian->asesor->id_asesor)
                ->orderBy('created_at', 'desc')
                ->first();
        }
            
        return view('home.home-asesor.fria07-pdf', compact('detailRincian', 'formData', 'tandaTanganAsesor'));
    }
}
