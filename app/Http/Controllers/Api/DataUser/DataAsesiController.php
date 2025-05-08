<?php

namespace App\Http\Controllers\Api\DataUser;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\ProgresAsesmen;
use Illuminate\Support\Facades\DB;
use App\Models\Asesi;
use App\Models\RincianAsesmen;

/**
 * @OA\Tag(
 *     name="Asesi",
 *     description="API Endpoints untuk pengelolaan data Asesi"
 * )
 */
class DataAsesiController extends Controller
{

    /**
     * Get data asesi for asesor dashboard page
     * 
     * @OA\Get(
     *     path="/asesor/asesis/{id}",
     *     summary="Mendapatkan daftar asesi berdasarkan asesor",
     *     tags={"Asesi"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID asesor",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data Asesor ditemukan"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="asesis", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id_asesi", type="string", example="1"),
     *                         @OA\Property(property="nama_asesi", type="string", example="Jane Doe"),
     *                         @OA\Property(property="nama_skema", type="string", example="Software Development"),
     *                         @OA\Property(property="nomor_skema", type="string", example="SKM-001")
     *                     )
     *                 ),
     *                 @OA\Property(property="jumlah_asesi", type="integer", example=5)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data asesor tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data Asesor tidak ditemukan")
     *         )
     *     )
     * )
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
     * 
     * @OA\Get(
     *     path="/asesor/progressAsesi/{id}",
     *     summary="Mendapatkan data progres asesmen asesi",
     *     tags={"Asesi"},
     *     security={{"api_key":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID asesi",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data Progress Asesmen ditemukan"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="progress_asesmen", type="object")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Data Progress Asesmen tidak ditemukan")
     *         )
     *     )
     * )
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
