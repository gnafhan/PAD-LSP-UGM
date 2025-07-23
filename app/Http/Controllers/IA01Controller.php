<?php

namespace App\Http\Controllers;

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
        if (request()->has('id_asesi')) {
            $detailRincian = $daftarAsesi->where('id_asesi', request('id_asesi'))->first();
            if (!$detailRincian) {
                $notFound = true;
            }
        }

        return view('home.home-asesor.fria01-asesor', compact('daftarAsesi', 'detailRincian', 'notFound'));
    }
}
