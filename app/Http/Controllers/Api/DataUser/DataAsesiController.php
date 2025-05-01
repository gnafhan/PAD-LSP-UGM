<?php

namespace App\Http\Controllers\Api\DataUser;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\ProgresAsesmen;
use Illuminate\Support\Facades\DB;
use App\Models\Asesi;
use App\Models\RincianAsesmen;


class DataAsesiController extends Controller
{

    /**
     * Get data asesi for asesor dashboard page
     */
    public function get_asesis(string $id){
        $asesor = Asesor::where('id_asesor', $id)->first();

        if ($asesor){
            $asesis = DB::table('rincian_asesmen')
            ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
            ->where('rincian_asesmen.id_asesor', $id)
            ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
            ->select('asesi.id_asesi', 'asesi.nama_asesi', 'skema.nama_skema', 'skema.nomor_skema');
            if ($asesis){
                return response()->json([
                    'success' => true,
                    'message' => 'Data Asesor ditemukan',
                    'data'    => [
                        'asesis' => $asesis->get(),
                        'jumlah_asesi' => $asesis->count()
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Asesi tidak ditemukan'
                ], 404);
            }

        }
        return response()->json([
            'success' => false,
            'message' => 'Data Asesor tidak ditemukan'
        ], 404);
    }

    /**
     * Get asesi's progress asesmen
     */
    public function get_progress_asesmen(string $id){
        $progress_asesmen = ProgresAsesmen::where('id_asesi', $id)->first();

        if ($progress_asesmen){
            return response()->json([
                'success' => true,
                'message' => 'Data Progress Asesmen ditemukan',
                'data'    => [
                    'progress_asesmen' => $progress_asesmen
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Progress Asesmen tidak ditemukan'
            ], 404);
        }
    }
}
