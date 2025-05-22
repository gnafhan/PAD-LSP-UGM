<?php

use App\Http\Controllers\Api\DataUser\DataAsesorController;
use App\Http\Controllers\Api\DataUser\DataAsesiController;
use App\Http\Controllers\Api\Kompetensi\KompetensiTeknisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen\KonsultasiPraUjiController;
use App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen\Mapa02Controller;
use App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen\Ak01Controller;
use App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen\Mapa01Controller;
use App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen\KetidakberpihakkanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="LSP UGM API Documentation",
 *     description="API Documentation for LSP UGM Application",
 *     @OA\Contact(
 *         email="admin@lsp.ugm.ac.id"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="/api",
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="api_key",
 *     type="apiKey",
 *     name="X-API-KEY",
 *     in="header"
 * )
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Asesor
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/asesor')->group(function () {

        // UPDATE dan READ Biodata Asesor
        Route::put('/biodata/{id}', [DataAsesorController::class, 'update_biodata']);
        Route::get('/biodata/{id}', [DataAsesorController::class, 'show_biodata']);

        // GET Kompetensi Teknis asesor
        Route::get('/kompetensi_teknis/{id}', [KompetensiTeknisController::class, 'index']);

        // GET data for dashboard
        Route::get('/dashboard/{id}', [DataAsesorController::class, 'dashboard_asesor']);
        Route::get('/asesis/{id}', [DataAsesiController::class, 'get_asesis']);
        Route::get('/progressAsesi/{id}', [DataAsesiController::class, 'get_progress_asesmen']);
    });
});

// Route for Konsultasi Pra Uji
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/asesmen/konsultasi-prauji')->group(function () {
        // Get data (common endpoint for both Asesi and Asesor)
        Route::get('/{id_asesi}', [KonsultasiPraUjiController::class, 'getKonsultasiPraUji']);
        
        // Save data - separate endpoints for Asesi and Asesor
        Route::post('/asesi/save', [KonsultasiPraUjiController::class, 'saveKonsultasiPraUjiAsesi']);
        Route::post('/asesor/save', [KonsultasiPraUjiController::class, 'saveKonsultasiPraUjiAsesor']);
    });
});

// Route for MAPA01
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/asesmen/mapa01')->group(function () {
        // Get data 
        Route::get('/{id_asesi}', [Mapa01Controller::class, 'getMapa01']);
        
        // Save data
        Route::post('/save', [Mapa01Controller::class, 'saveMapa01']);
    });
});

// Route for MAPA.02
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/asesmen/mapa02')->group(function () {
        // Get data 
        Route::get('/{id_asesi}', [Mapa02Controller::class, 'getMapa02']);
        
        // Save data
        Route::post('/save', [Mapa02Controller::class, 'saveMapa02']);
    });
});

// Route for AK01
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/asesmen/ak01')->group(function () {
        // Get data 
        Route::get('/{id_asesi}', [Ak01Controller::class, 'getAk01']);
        
        // Save data - separate endpoints for Asesi and Asesor
        Route::post('/asesi/save', [Ak01Controller::class, 'saveAk01Asesi']);
        Route::post('/asesor/save', [Ak01Controller::class, 'saveAk01Asesor']);
    });
});

// Route for Ketidakberpihakan
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/asesmen/ketidakberpihakan')->group(function () {
        // Get data
        Route::get('/{id_asesi}', [KetidakberpihakkanController::class, 'getKetidakberpihakan']);
        
        // Sign form
        Route::post('/sign', [KetidakberpihakkanController::class, 'signKetidakberpihakan']);
    });
});