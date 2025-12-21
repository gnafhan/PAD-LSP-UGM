<?php

namespace App\Http\Controllers\Api\DataUser;

use App\Http\Controllers\Controller;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\ProgresAsesmen;
use App\Services\AsesiDashboardService;
use App\Services\SkemaConfigService;
use Illuminate\Support\Facades\DB;
use App\Helpers\DateTimeHelper;

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
            // Get base asesi data - using asesi_muk table which has consistent assignment data
            $asesisQuery = DB::table('rincian_asesmen')
                ->join('asesi', 'rincian_asesmen.id_asesi', '=', 'asesi.id_asesi')
                ->where('rincian_asesmen.id_asesor', $id)
                ->join('skema', 'asesi.id_skema', '=', 'skema.id_skema')
                ->select('asesi.id_asesi', 'asesi.nama_asesi', 'skema.nama_skema', 'skema.nomor_skema');
            
            $asesis = $asesisQuery->get();
            // @dd($asesis);
            
            if ($asesis){
                // Get progress data and calculate percentage for each asesi
                foreach ($asesis as $key => $asesi) {
                    $progres = ProgresAsesmen::where('id_asesi', $asesi->id_asesi)->first();
                    
                    if ($progres) {
                        // Use the new calculation method
                        $progressData = $progres->calculateProgress();
                        
                        // Add to asesi data
                        $asesis[$key]->progress_percentage = $progressData['progress_percentage'];
                        $asesis[$key]->completed_steps = $progressData['completed_steps'];
                        $asesis[$key]->total_steps = $progressData['total_steps'];
                        
                        // Add information about the latest completion time
                        $structured = $progres->getStructuredProgress();
                        $latestTime = null;

                        foreach ($structured as $step => $data) {
                            if (isset($data['completed']) && $data['completed'] && isset($data['completed_at'])) {
                                if ($latestTime === null || strtotime($data['completed_at']) > strtotime($latestTime)) {
                                    $latestTime = $data['completed_at'];
                                }
                            }
                        }
                        
                        // Konversi ke format WIB menggunakan helper
                        $asesis[$key]->latest_activity = DateTimeHelper::toWIB($latestTime);
                    } else {
                        // If no progress record exists
                        $asesis[$key]->progress_percentage = 0;
                        $asesis[$key]->completed_steps = 0;
                        $asesis[$key]->total_steps = 14; // Number of progress fields
                        $asesis[$key]->latest_activity = null;
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data Asesor ditemukan',
                    'data'    => [
                        'asesis' => $asesis,
                        'jumlah_asesi' => count($asesis),
                        'timezone' => 'WIB'
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
     *                 @OA\Property(property="progress_asesmen", type="object"),
     *                 @OA\Property(property="progress_summary", type="object")
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
        $asesi = Asesi::with('skema')->where('id_asesi', $id)->first();

        if ($progress_asesmen){
            // Get structured progress data using the new method
            $structured_progress = $progress_asesmen->getStructuredProgress();
            
            // Convert all timestamps to WIB format
            foreach ($structured_progress as $step => &$data) {
                if (isset($data['completed_at']) && $data['completed_at']) {
                    $data['completed_at'] = DateTimeHelper::toWIB($data['completed_at']);
                }
            }
            
            // Calculate progress summary
            $progress_summary = $progress_asesmen->calculateProgress();
            
            // Get enabled assessments for the scheme
            $enabled_assessments = [];
            $assessment_sections = [];
            
            if ($asesi && $asesi->id_skema) {
                $skemaConfigService = app(SkemaConfigService::class);
                $asesiDashboardService = app(AsesiDashboardService::class);
                
                $enabled_assessments = $skemaConfigService->getEnabledAssessments($asesi->id_skema)->toArray();
                $assessment_sections = $asesiDashboardService->getFilteredAssessmentSections($asesi);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Data Progress Asesmen ditemukan',
                'data'    => [
                    'progress_asesmen' => $structured_progress,
                    'progress_summary' => $progress_summary,
                    'enabled_assessments' => $enabled_assessments,
                    'assessment_sections' => $assessment_sections,
                    'timezone' => 'WIB'
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