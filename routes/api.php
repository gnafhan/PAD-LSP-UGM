<?php

use App\Http\Controllers\Api\DataUser\DataAsesorController;
use App\Http\Controllers\Api\DataUser\DataAsesiController;
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

// Admin
Route::middleware('api_key')->group(function () {
    Route::prefix('/v1/admin')->group(function () {
        

    });
});