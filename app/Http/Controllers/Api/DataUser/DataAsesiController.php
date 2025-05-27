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
     *                         @OA\Property(property="nomor_skema", type="string", example="SKM-001"),
     *                         @OA\Property(property="progress_percentage", type="int", example="50"),
     *                         @OA\Property(property="completed_steps", type="int", example="5"),
     *                         @OA\Property(property="total_steps", type="int", example="10"),
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
            // Get base asesi data
            $asesisQuery = DB::table('rincian_asesmen')
                ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
                ->where('rincian_asesmen.id_asesor', $id)
                ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
                ->select('asesi.id_asesi', 'asesi.nama_asesi', 'skema.nama_skema', 'skema.nomor_skema');
            
            $asesis = $asesisQuery->get();
            
            if ($asesis){
                // Get progress data and calculate percentage for each asesi
                foreach ($asesis as $key => $asesi) {
                    $progres = ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->first();
                    
                    if ($progres) {
                        // Get all tracked progress fields (excluding id_asesi and timestamps)
                        $progressFields = [
                            'apl01', 'apl02', 'ak01', 'konsultasi_pra_uji', 
                            'mapa01', 'mapa02', 'pertanyaan_ketidak_berpihakan',
                            'ak07', 'ia01', 'ia02', 'hasil_asesmen',
                            'ak02', 'umpan_balik', 'ak04'
                        ];
                        
                        // Count completed steps
                        $completedSteps = 0;
                        foreach ($progressFields as $field) {
                            if ($progres->$field) {
                                $completedSteps++;
                            }
                        }
                        
                        // Calculate percentage
                        $totalSteps = count($progressFields);
                        $percentage = ($totalSteps > 0) ? round(($completedSteps / $totalSteps) * 100) : 0;
                        
                        // Add to asesi data
                        $asesis[$key]->progress_percentage = $percentage;
                        $asesis[$key]->completed_steps = $completedSteps;
                        $asesis[$key]->total_steps = $totalSteps;
                    } else {
                        // If no progress record exists
                        $asesis[$key]->progress_percentage = 0;
                        $asesis[$key]->completed_steps = 0;
                        $asesis[$key]->total_steps = 14; // Number of progress fields
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data Asesor ditemukan',
                    'data'    => [
                        'asesis' => $asesis,
                        'jumlah_asesi' => count($asesis)
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
