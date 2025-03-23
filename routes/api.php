<?php

use App\Http\Controllers\Api\User\API_AsesorController;
use App\Http\Controllers\Api\Kompetensi\KompetensiTeknisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Asesor
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/asesor')->group(function () {

        // UPDATE dan READ Biodata Asesor
        Route::put('/biodata/{id}', [API_AsesorController::class, 'update_biodata']);
        Route::get('/biodata/{id}', [API_AsesorController::class, 'show_biodata']);

        // GET Kompetensi Teknis asesor
        Route::get('/kompetensi_teknis/{id}', [KompetensiTeknisController::class, 'index']);
    });
});

// Admin
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/admin')->group(function () {
        
        // POST Kompetensi Teknis Asesor
        Route::get('/kompetensi_teknis/show_asesor/', [API_AsesorController::class, 'show_asesor']);
        Route::post('/kompetensi_teknis/', [KompetensiTeknisController::class, 'store']);

        // GET Daftar Kompetensi Teknis Asesor 
        // Route::post('/kompetensi_teknis/', [KompetensiTeknisController::class, 'store']);

    });
});