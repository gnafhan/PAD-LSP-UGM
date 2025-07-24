<?php

namespace App\Http\Controllers;

use App\Models\Fria01;
use App\Models\RincianAsesmen;
use Illuminate\Http\Request;

class IA01Controller extends Controller
{
    public function index()
    {
        $daftarAsesi = RincianAsesmen::with([
            'asesi.skema',
            'asesi.progresAsesmen',
            'asesor',
            'event.tuk',
        ])->get();

        $detailRincian = null;
        $notFound = false;
        $formData = null;
        
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

        return view('home.home-asesor.fria01-asesor', compact('daftarAsesi', 'detailRincian', 'notFound', 'formData'));
    }
}
