<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\Ak07;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\JawabanBanding;
use App\Models\PertanyaanBanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FRAK07Controller extends Controller
{
    public function show(R$id_asesi){
        $asesi = Asesi::where('id_asesi', $id_asesi)->first();
        // asesor
        $id_asesor = Auth::user()->asesor->id_asesor;

        if(Auth::user()->asesor->id_asesor != $asesi->id_asesor){
            return redirect()->route('frak04-asesor');
        }

        // Find or create AK07 record
        $ak07 = Ak07::firstOrNew([
            'id_asesi' => $id_asesi,
            'id_asesor' => $id_asesor,
        ]);

        @dd($id_asesi);

        return view('home/home-asesor/frak07-asesor');
    }
}
