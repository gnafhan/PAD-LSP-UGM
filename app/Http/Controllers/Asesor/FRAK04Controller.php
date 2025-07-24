<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\JawabanBanding;
use App\Models\PertanyaanBanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FRAK04Controller extends Controller
{
    public function index(Request $request){
        $asesor = Auth::user()->asesor;
        $q = $request->input('q');
        if($asesor){
            $asesisQuery = DB::table('rincian_asesmen')
                ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
                ->where('rincian_asesmen.id_asesor', $asesor->id_asesor)
                ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
                ->select('asesi.id_asesi', 'asesi.nama_asesi', 'skema.nama_skema', 'skema.nomor_skema');

            if ($q) {
                $asesisQuery->where(function($query) use ($q) {
                    $query->where('asesi.nama_asesi', 'like', "%$q%")
                          ->orWhere('skema.nama_skema', 'like', "%$q%")
                          ->orWhere('skema.nomor_skema', 'like', "%$q%") ;
                });
            }
            $asesis = $asesisQuery->get();
        } else {
            $asesis = collect();
        }
        return view('home/home-asesor/frak04-asesor', compact(['asesis', 'q']));
    }

    public function show($id_asesi){
        $asesi = Asesi::where('id_asesi', $id_asesi)->first();

        $asesi = DB::table('asesi')
            ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
            ->join('rincian_asesmen', 'asesi.id_asesi', '=', 'rincian_asesmen.id_asesi')
            ->join('event', 'rincian_asesmen.id_event', '=', 'event.id_event')
            ->join('tuk', 'event.id_tuk', '=', 'tuk.id_tuk')
            ->join('asesor', 'rincian_asesmen.id_asesor', '=', 'asesor.id_asesor')
            ->where('asesi.id_asesi', $id_asesi)
            ->select('asesi.id_asesi', 'asesi.nama_asesi', 'skema.nama_skema', 'skema.nomor_skema', 'tuk.nama_tuk', 'asesor.nama_asesor', 'asesor.id_asesor', 'rincian_asesmen.id_rincian_asesmen')
            ->first();

        if(Auth::user()->asesor->id_asesor != $asesi->id_asesor){
            return redirect()->route('frak04-asesor');
        }

        // get pertanyaan banding sort by order
        $pertanyaan_banding = PertanyaanBanding::orderBy('order', 'asc')->get();

        $jawaban_banding = JawabanBanding::where('id_rincian_asesmen', $asesi->id_rincian_asesmen)->get();

        return view('home/home-asesor/frak04-asesor-detail', compact(['asesi', 'pertanyaan_banding', 'jawaban_banding']));
    }
}
