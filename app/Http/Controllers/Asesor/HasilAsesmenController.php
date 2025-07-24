<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\Asesi;
use App\Models\HasilAsesmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HasilAsesmenController extends Controller
{
    public function index(Request $request){
        $asesor = Auth::user()->asesor;
        if($asesor){
            $hasilAsesmensQuery = DB::table('hasil_asesmen')
            ->join('rincian_asesmen', 'hasil_asesmen.id_rincian_asesmen', '=', 'rincian_asesmen.id_rincian_asesmen')
            ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
            ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
            ->join('event', 'rincian_asesmen.id_event', '=', 'event.id_event')
            ->join('tuk', 'event.id_tuk', '=', 'tuk.id_tuk')
            ->where('rincian_asesmen.id_asesor', $asesor->id_asesor)
            ->select('hasil_asesmen.id', 'hasil_asesmen.status', 'asesi.nama_asesi', 'skema.nama_skema', 'skema.nomor_skema', 'tuk.nama_tuk');
            
            if ($request->has('search') && $request->search !== null && trim($request->search) !== '') {
                $search = $request->search;
                $hasilAsesmensQuery->where(function($query) use ($search) {
                    $query->where('asesi.nama_asesi', 'like', "%$search%")
                          ->orWhere('skema.nama_skema', 'like', "%$search%")
                          ->orWhere('skema.nomor_skema', 'like', "%$search%")
                          ->orWhere('tuk.nama_tuk', 'like', "%$search%") ;
                });
            }
            $hasilAsesmens = $hasilAsesmensQuery->get();
            return view('home/home-asesor/hasil-asesmen', compact('hasilAsesmens'))->with('search', $request->search);
        }
        return redirect()->route('home-asesor');
    }
}
