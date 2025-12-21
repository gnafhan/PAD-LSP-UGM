<?php

use App\Http\Controllers\Admin\BidangKompetensiPageController;
use App\Http\Controllers\Admin\ManajemenAssignAsesiToAsesor\AsesiPengajuanPageController;
use App\Http\Controllers\Admin\ManajemenEvent\EventController;
use App\Http\Controllers\Admin\ManajemenPengguna\AdminUserController;
use App\Http\Controllers\Admin\ManajemenPengguna\AsesorController;
use App\Http\Controllers\Admin\ManajemenPengguna\KompetensiTeknisController;
use App\Http\Controllers\Admin\ManajemenPengguna\PenggunaPageController;
use App\Http\Controllers\Admin\ManajemenSkema\RencanaAsesmenController;
use App\Http\Controllers\Admin\ManajemenSkema\SkemaPageController;
use App\Http\Controllers\Admin\ManajemenTUK\PenanggungJawabController;
use App\Http\Controllers\Admin\ManajemenTUK\TukController;
use App\Http\Controllers\Admin\ManajemenUnitKompetensi\UnitKompetensiPageController;
use App\Http\Controllers\Admin\AsesorSkemaAssignmentController;
use App\Http\Controllers\Admin\DynamicContentController;
use App\Http\Controllers\Admin\SkemaAssessmentConfigController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AK04Controller;
use App\Http\Controllers\AsesiController;
use App\Http\Controllers\Asesor\FRAK04Controller;
use App\Http\Controllers\Asesor\HasilAsesmenController;
use App\Http\Controllers\Asesor\SchemeContextController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IA02ContentController;
use App\Http\Controllers\IA02TugasController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SwaggerController;
use App\Http\Controllers\TempImageController;
use App\Http\Controllers\TugasPesertaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController;


// API Documentation
Route::get('api/documentation', [SwaggerController::class, 'index'])
    ->name('l5-swagger.default.api');

// Test routes
Route::get('/test-custom-resize', function () {
    return view('test-custom-resize');
})->name('test.custom.resize');

// Level: user
Route::middleware(['role:user'])->prefix('user')->group(function () {

    // Dashboard User
    Route::get('/home', function () {
        return view('home/home-visitor/home');
    })->name('home');

    // Persetujuan TTD
    Route::prefix('persetujuan')->name('user.persetujuan.')->group(function () {
        Route::get('/ttd', [PengajuanController::class, 'indexPersetujuan'])->name('index');
        Route::post('/save', [PengajuanController::class, 'saveDataPersetujuan'])->name('save');
    });

    // APL-01 Pengajuan Sertifikasi
    Route::prefix('apl1')->name('user.apl1.')->group(function () {
        // Data Pribadi
        Route::get('/b1', [PengajuanController::class, 'showDataPribadi'])->name('pribadi');
        Route::post('/save-data-pribadi', [PengajuanController::class, 'saveDataPribadi']);

        // Data Sertifikasi
        Route::get('/b2', [PengajuanController::class, 'showDataSertifikasi'])->name('sertifikasi');
        Route::get('/get-nomor-skema', [PengajuanController::class, 'getNomorSkema']);
        Route::get('/get-daftar-uk', [PengajuanController::class, 'showDaftarUK']);
        Route::post('/save-data-sertifikasi', [PengajuanController::class, 'saveDataSertifikasi'])->name('save.data.sertifikasi');

        // Bukti Kelengkapan
        Route::get('/b3', [PengajuanController::class, 'showBuktiKelengkapan'])->name('bukti');
        Route::post('/save-bukti-kelengkapan', [PengajuanController::class, 'saveBuktiKelengkapan'])->name('save.bukti');

        // Konfirmasi
        Route::get('/b4', [PengajuanController::class, 'showKonfirmasi'])->name('konfirmasi');
        Route::post('/submit-pengajuan', [PengajuanController::class, 'submitPengajuan'])->name('submit');

        Route::post('pengajuan/restart', [PengajuanController::class, 'restartPengajuan'])->name('restart');
    });

    // Logout User
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});


//Level: admin
Route::middleware(['role:admin'])->prefix('admin')->group(function () {

    // Dashboard Admin
    Route::get('/home-admin', [AdminController::class, 'index'])->name('home-admin');
    
    Route::prefix('soal')->name('admin.soal.')->group(function () {
        Route::get('/', [SoalController::class, 'index'])->name('index');
        Route::get('/by-skema/{skema}', [SoalController::class, 'getSoalBySkema'])->name('bySkema');
        Route::get('create', [SoalController::class, 'create'])->name('create');
        Route::post('create', [SoalController::class, 'store'])->name('store');
        Route::get('{kode_soal}', [SoalController::class, 'show'])->name('show');
        Route::get('{kode_soal}/edit', [SoalController::class, 'edit'])->name('edit');
        Route::put('{kode_soal}', [SoalController::class, 'update'])->name('update');
        Route::delete('{kode_soal}', [SoalController::class, 'destroy'])->name('destroy');
    });

    // Manajemen Skema
    Route::prefix('skema')->name('admin.skema.')->group(function () {
        Route::get('/', [SkemaPageController::class, 'indexDataSkema'])->name('index');
        Route::get('create', [SkemaPageController::class, 'createDataSkema'])->name('create');
        Route::post('create', [SkemaPageController::class, 'storeDataSkema'])->name('store');
        Route::get('{id}/edit', [SkemaPageController::class, 'editDataSkema'])->name('edit');
        Route::put('{id}/update', [SkemaPageController::class, 'updateDataSkema'])->name('update');
    });

    // Manajemen Unit Kompetensi (UK)
    Route::prefix('uk')->name('admin.uk.')->group(function () {
        Route::get('/', [UnitKompetensiPageController::class, 'indexDataUk'])->name('index');
        Route::get('create', [UnitKompetensiPageController::class, 'createDataUk'])->name('create');
        Route::get('getUK', [UnitKompetensiPageController::class, 'getUK'])->name('getUK');
        Route::post('create', [UnitKompetensiPageController::class, 'storeDataUk'])->name('store');
        Route::get('{id}/edit', [UnitKompetensiPageController::class, 'editDataUk'])->name('edit');
        Route::put('{id}/update', [UnitKompetensiPageController::class, 'updateDataUk'])->name('update');
    });

    Route::prefix('bidang-kompetensi')->name('admin.bidang-kompetensi.')->group(function () {
        Route::get('/', [BidangKompetensiPageController::class, 'indexDataBidangKompetensi'])->name('index');
        Route::get('create', [BidangKompetensiPageController::class, 'createDataBidangKompetensi'])->name('create');
        Route::post('create', [BidangKompetensiPageController::class, 'storeDataBidangKompetensi'])->name('store');
        Route::get('{id}/edit', [BidangKompetensiPageController::class, 'editDataBidangKompetensi'])->name('edit');
        Route::put('{id}/update', [BidangKompetensiPageController::class, 'updateDataBidangKompetensi'])->name('update');
        Route::delete('delete/{id}', [BidangKompetensiPageController::class, 'destroyDataBidangKompetensi'])->name('delete');
    });

    // Manajemen Rencana Asesmen
    Route::prefix('skema/{id_skema}/rencana-asesmen')->name('admin.skema.rencana-asesmen.')->group(function () {
        Route::get('/', [RencanaAsesmenController::class, 'index'])->name('index');
        Route::get('/uk/{id_uk}', [RencanaAsesmenController::class, 'getByUK'])->name('getByUK');
        Route::post('/store', [RencanaAsesmenController::class, 'store'])->name('store');
        Route::post('/generate/{id_uk}', [RencanaAsesmenController::class, 'generateFromElemen'])->name('generate');
        Route::delete('/{id_rencana_asesmen}', [RencanaAsesmenController::class, 'destroy'])->name('destroy');
    });

    // Skema Assessment Configuration (Dynamic Assessment Flow)
    // Requirements: 1.1, 1.2, 1.3, 1.4, 2.1, 2.2
    Route::prefix('skema/{id}/assessment-config')->name('admin.skema.assessment-config.')->group(function () {
        Route::get('/', [SkemaAssessmentConfigController::class, 'index'])->name('index');
        Route::get('/view', [SkemaAssessmentConfigController::class, 'show'])->name('view');
        Route::put('/', [SkemaAssessmentConfigController::class, 'update'])->name('update');
    });

    // Asesor Skema Assignment Management (Dynamic Assessment Flow)
    // Requirements: 3.1, 3.2, 3.3
    Route::get('/asesor-assignments', [AsesorSkemaAssignmentController::class, 'showAssignmentsPage'])->name('admin.asesor-assignments.index');
    Route::prefix('asesor/{id}')->name('admin.asesor.')->group(function () {
        Route::get('/assignments', [AsesorSkemaAssignmentController::class, 'index'])->name('assignments.index');
        Route::post('/assign-skema', [AsesorSkemaAssignmentController::class, 'store'])->name('assignments.store');
        Route::delete('/revoke-skema/{skemaId}', [AsesorSkemaAssignmentController::class, 'destroy'])->name('assignments.destroy');
    });

    // Dynamic Assessment Content Management (Dynamic Assessment Flow)
    // Requirements: 4.1, 4.2, 4.3, 4.4, 4.5
    Route::prefix('assessment-content')->name('admin.assessment-content.')->group(function () {
        Route::get('/manage/{skemaId}', [DynamicContentController::class, 'showContentPage'])->name('manage');
        Route::get('/{skemaId}/{type}', [DynamicContentController::class, 'index'])->name('index');
        Route::post('/', [DynamicContentController::class, 'store'])->name('store');
        Route::put('/{id}', [DynamicContentController::class, 'update'])->name('update');
        Route::delete('/{id}', [DynamicContentController::class, 'destroy'])->name('destroy');
    });

    // Scheme Content Management per Template IA (Assessment Content per Template)
    // Requirements: 1.1-1.5, 2.1-2.4, 3.1-3.4, 4.1-4.3, 5.1-5.3, 6.1-6.4, 7.1, 9.1-9.3
    Route::prefix('skema/{id}/content')->name('admin.skema.content.')->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\SchemeContentController::class, 'index'])->name('index');
        Route::get('/summary', [\App\Http\Controllers\Admin\SchemeContentController::class, 'summary'])->name('summary');
        
        // IA05 - Multiple Choice Questions
        Route::get('/ia05', [\App\Http\Controllers\Admin\IA05ContentController::class, 'index'])->name('ia05.index');
        Route::post('/ia05', [\App\Http\Controllers\Admin\IA05ContentController::class, 'store'])->name('ia05.store');
        Route::put('/ia05/{kode}', [\App\Http\Controllers\Admin\IA05ContentController::class, 'update'])->name('ia05.update');
        Route::delete('/ia05/{kode}', [\App\Http\Controllers\Admin\IA05ContentController::class, 'destroy'])->name('ia05.destroy');
        Route::post('/ia05/reorder', [\App\Http\Controllers\Admin\IA05ContentController::class, 'reorder'])->name('ia05.reorder');
        
        // IA02 - Work Instructions Template
        Route::get('/ia02', [\App\Http\Controllers\Admin\IA02ContentController::class, 'show'])->name('ia02.show');
        Route::post('/ia02', [\App\Http\Controllers\Admin\IA02ContentController::class, 'store'])->name('ia02.store');
        
        // IA07 - Oral Questions
        Route::get('/ia07', [\App\Http\Controllers\Admin\IA07ContentController::class, 'index'])->name('ia07.index');
        Route::post('/ia07', [\App\Http\Controllers\Admin\IA07ContentController::class, 'store'])->name('ia07.store');
        Route::put('/ia07/{questionId}', [\App\Http\Controllers\Admin\IA07ContentController::class, 'update'])->name('ia07.update');
        Route::delete('/ia07/{questionId}', [\App\Http\Controllers\Admin\IA07ContentController::class, 'destroy'])->name('ia07.destroy');
        
        // MAPA01 - Assessment Planning Config
        Route::get('/mapa01', [\App\Http\Controllers\Admin\MAPAConfigController::class, 'showMAPA01'])->name('mapa01.show');
        Route::post('/mapa01', [\App\Http\Controllers\Admin\MAPAConfigController::class, 'storeMAPA01'])->name('mapa01.store');
        
        // MAPA02 - Assessment Instrument Config
        Route::get('/mapa02', [\App\Http\Controllers\Admin\MAPAConfigController::class, 'showMAPA02'])->name('mapa02.show');
        Route::post('/mapa02', [\App\Http\Controllers\Admin\MAPAConfigController::class, 'storeMAPA02'])->name('mapa02.store');
        
        // IA11 - Portfolio Checklist
        Route::get('/ia11', [\App\Http\Controllers\Admin\IA11ContentController::class, 'index'])->name('ia11.index');
        Route::post('/ia11', [\App\Http\Controllers\Admin\IA11ContentController::class, 'store'])->name('ia11.store');
        Route::put('/ia11/{itemId}', [\App\Http\Controllers\Admin\IA11ContentController::class, 'update'])->name('ia11.update');
        Route::delete('/ia11/{itemId}', [\App\Http\Controllers\Admin\IA11ContentController::class, 'destroy'])->name('ia11.destroy');
    });

    // Content Copy between Schemes
    Route::prefix('content/copy')->name('admin.content.copy.')->group(function () {
        Route::get('/sources', [\App\Http\Controllers\Admin\ContentCopyController::class, 'sources'])->name('sources');
        Route::post('/', [\App\Http\Controllers\Admin\ContentCopyController::class, 'copy'])->name('copy');
    });


    // Manajemen TUK
    Route::prefix('tuk')->name('admin.tuk.')->group(function () {
        Route::get('/', [TukController::class, 'index'])->name('index');
        Route::get('/create', [TukController::class, 'create'])->name('create');
        Route::post('/', [TukController::class, 'store'])->name('store');
        Route::put('/{id}', [TukController::class, 'update'])->name('update');
    });

    // Manajemen Penanggung Jawab
    Route::prefix('penanggung-jawab')->name('admin.penanggung-jawab.')->group(function () {
        Route::post('/', [PenanggungJawabController::class, 'store'])->name('store');
        Route::put('/{id}', [PenanggungJawabController::class, 'update'])->name('update');
    });

    // Routes for Event Management
    Route::prefix('event')->name('admin.event.')->group(function () {
        Route::get('/', [EventController::class, 'indexDataEvent'])->name('index');
        Route::get('/create', [EventController::class, 'createDataEvent'])->name('create');
        Route::post('store', [EventController::class, 'storeDataEvent'])->name('store');
        Route::get('edit/{id}', [EventController::class, 'editDataEvent'])->name('edit');
        Route::put('update/{id}', [EventController::class, 'updateDataEvent'])->name('update');
        Route::delete('delete/{id}', [EventController::class, 'destroyDataEvent'])->name('delete');
        Route::get('detail/{id}', [EventController::class, 'detailEvent'])->name('detail');
    });


    // Manajemen Asesi
    Route::prefix('asesi')->name('admin.asesi.')->group(function () {
        Route::get('/', [AsesiPengajuanPageController::class, 'indexDataAsesi'])->name('index');
        Route::post('{id}/process', [AsesiPengajuanPageController::class, 'processAsesi'])->name('process');
        Route::get('{id}/detail', [AsesiPengajuanPageController::class, 'showPengajuanDetail'])->name('detail');
        Route::get('{id}/show', [AsesiPengajuanPageController::class, 'showAsesiDetail'])->name('show');
        Route::get('{id}/edit', [AsesiPengajuanPageController::class, 'editAsesi'])->name('edit');
        Route::put('{id}/update', [AsesiPengajuanPageController::class, 'updateAsesi'])->name('update');
        Route::post('/pengajuan/{id_pengajuan}/revisi', [AsesiPengajuanPageController::class, 'requestRevision'])->name('request.revision');
        
        // Certificate management (manual upload by admin)
        // Requirements: 1.1, 1.2, 1.3, 1.4, 2.1, 2.2, 2.3, 5.1, 5.2
        Route::post('{id}/certificate/upload', [\App\Http\Controllers\Admin\CertificateUploadController::class, 'upload'])->name('certificate.upload');
        Route::get('{id}/certificate/download', [\App\Http\Controllers\Admin\CertificateUploadController::class, 'download'])->name('certificate.download');
        Route::delete('{id}/certificate/delete', [\App\Http\Controllers\Admin\CertificateUploadController::class, 'delete'])->name('certificate.delete');
    });

    // Manajemen Asesor untuk Asesi untuk fitur dependent dropdown list
    Route::post('assign-asesor', [AsesiPengajuanPageController::class, 'assignAsesor'])->name('assign.asesor');
    Route::put('asesi/assignment/{id}', [AsesiPengajuanPageController::class, 'updateAssignment'])->name('asesi.assignment.update');
    Route::get('get-asesor-by-bidang/{id_bidang}', [AsesiPengajuanPageController::class, 'getAsesorByBidang'])->name('get.asesor.by.bidang');
    Route::get('get-all-asesor', [AsesiPengajuanPageController::class, 'getAllAsesor'])->name('get.all.asesor');


    // Manajemen Pengguna
    Route::prefix('pengguna')->name('admin.pengguna.')->group(function () {
        // Dashboard Pengguna (Main view)
        Route::get('/', [PenggunaPageController::class, 'index'])->name('index');
        Route::get('tambah-pengguna', [PenggunaPageController::class, 'create'])->name('create');

        // Bidang Kompetensi Management
        Route::post('bidang-kompetensi/create', [PenggunaPageController::class, 'createBidangKompetensi'])->name('bidang-kompetensi.create');

        // Admin User Management
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::post('store', [AdminUserController::class, 'store'])->name('store');
            Route::put('{id}/update', [AdminUserController::class, 'update'])->name('update');
            Route::get('{id}/signature', [AdminUserController::class, 'getSignature'])->name('signature');
        });

        // Asesor Management
        Route::prefix('asesor')->name('asesor.')->group(function () {
            Route::get('create', [AsesorController::class, 'create'])->name('create');
            Route::post('store', [AsesorController::class, 'store'])->name('store');
            Route::get('{id}/edit', [AsesorController::class, 'edit'])->name('edit');
            Route::put('{id}/update-status', [AsesorController::class, 'updateStatus'])->name('update-status');
            Route::get('{id}', [AsesorController::class, 'show'])->name('show');
        });

        // Kompetensi Teknis Management
        Route::prefix('kompetensi')->name('kompetensi.')->group(function () {
            Route::get('{id}', [KompetensiTeknisController::class, 'index'])->name('index');
            Route::get('{id}/create', [KompetensiTeknisController::class, 'create'])->name('create');
            Route::post('{id}/store', [KompetensiTeknisController::class, 'store'])->name('store');
            Route::get('{id}/show/{kompetensiId}', [KompetensiTeknisController::class, 'show'])->name('show');
            Route::get('{id}/edit/{kompetensiId}', [KompetensiTeknisController::class, 'edit'])->name('edit');
            Route::put('{id}/update/{kompetensiId}', [KompetensiTeknisController::class, 'update'])->name('update');
            Route::delete('{id}/destroy/{kompetensiId}', [KompetensiTeknisController::class, 'destroy'])->name('destroy');
            Route::get('{id}/json', [KompetensiTeknisController::class, 'getSertifikatJson'])->name('json');
        });
    });

    Route::get('/btn-asesi', function () {
        return view('home/home-admin/button-asesi');
    });
    Route::get('/settings', function () {
        return view('home/home-admin/settings');
    });

    // Logout admin
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});


//Level: asesi
Route::middleware(['role:asesi'])->prefix('asesi')->group(function () {

    // Dashboard Asesi
    Route::get('/home', [AsesiController::class, 'index'])->name('home-asesi');
    Route::get('/', [AsesiController::class, 'indexAssesi'])->name('asesi.index');

    // APL-02 Asesmen Mandiri (APL is mandatory, no middleware needed)
    Route::get('/apl2', [AsesiController::class, 'asesmenMandiri'])->name('asesi.asesmen.mandiri');

    // ALUR FR.APL-01 (APL is mandatory, no middleware needed)
    Route::get('/apl1/{id}', [AsesiController::class, 'detailApl1'])->name('asesi.apl1-detail');

    // Pilih Aksi Home Asesi
    Route::view('/aksi', 'home/home-asesi/pilih-aksi')->name('asesi.pilih-aksi');
    Route::view('/persetujuan', 'home/home-asesi/persetujuan')->name('asesi.persetujuan');

    // FRAK-01, FRAK-03, FRIA-02 with access control middleware
    // Requirements: 5.3 - Redirect with message if accessing disabled assessment
    Route::prefix('fr')->name('asesi.fr.')->group(function () {
        Route::view('/ak1', 'home/home-asesi/FRAK-01/frak01')->name('ak1')->middleware('asesi.assessment:AK01');
        Route::view('/ak2', 'home/home-asesi/FRAK-02/frak02')->name('ak2'); // Hasil Asesmen - no middleware, always available
        Route::view('/ak3', 'home/home-asesi/FRAK-03/frak3')->name('ak3');
        Route::view('/ak07', 'home/home-asesi/FRAK-07/frak07')->name('ak07')->middleware('asesi.assessment:AK07');
    });

    // FRIA-02 with access control middleware
    Route::middleware(['asesi.assessment:IA02'])->group(function () {
        Route::get('/ia2', [AsesiController::class, 'fria2'])->name('asesi.fr.ia2');
        Route::get('/ia2/{id}', [AsesiController::class, 'detail_fria02'])->name('asesi.fr.ia2.detail');
        Route::get('/ia2/soal/{id}', [AsesiController::class, 'soal_praktek_fria02'])->name('asesi.fr.ia2.soal');
    });

    // FRIA-05 Pertanyaan Tertulis Pilihan Ganda with access control middleware
    Route::get("/ia05", function () {
        return view("home/home-asesi/FRIA-05/fria05");
    })->name("asesi.fr.ia05")->middleware("asesi.assessment:IA05");

    // IA02 Tugas Management with access control middleware
    Route::prefix('tugas')->name('asesi.tugas.')->middleware(['asesi.assessment:IA02'])->group(function () {
        Route::get('/soal-praktek', [IA02TugasController::class, 'soalPraktek'])->name('soal-praktek');
        Route::post('/store', [IA02TugasController::class, 'store'])->name('store');
        Route::get('/{id}', [IA02TugasController::class, 'show'])->name('show');
        Route::delete('/{id}', [IA02TugasController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/download', [IA02TugasController::class, 'downloadFile'])->name('download');
        Route::get('/data/json', [IA02TugasController::class, 'getTasks'])->name('data');
    });

    // FRAK-04 with access control middleware
    Route::get('/frak04', [AK04Controller::class, 'index'])->name('asesi.frak04')->middleware('asesi.assessment:AK04');
    Route::post('/frak04', [AK04Controller::class, 'storeBanding'])->name('store.banding.asesi')->middleware('asesi.assessment:AK04');

    // Jadwal Uji Kompetensi
    Route::view('/jadwal-uji-kompetensi', 'home/home-asesi/APL-02/jadwal-uji-kompetensi')->name('asesi.jadwal-uji-kompetensi');

    // Konsul Prauji with access control middleware
    Route::view('/konsul-prauji', 'home/home-asesi/konsul-prauji')->name('asesi.konsul-prauji')->middleware('asesi.assessment:KONSUL_PRA_UJI');

    // Certificate Download (uploaded by admin)
    // Requirements: 4.1, 4.2, 4.3
    Route::prefix('certificate')->name('asesi.certificate.')->group(function () {
        Route::get('/download', [\App\Http\Controllers\AsesiController::class, 'downloadCertificate'])->name('download');
    });

    // Logout asesi
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('asesi.logout');
});

// Temporary test route for FRIA02 without middleware (remove in production)
Route::get('/test-fria02', function () {
    return view('home/home-asesor/fria02-asesor');
})->name('test-fria02');

// Temporary test route for FRIA11 without middleware (remove in production)  
Route::get('/test-fria11', function () {
    return view('home/home-asesor/fria11-asesor');
})->name('test-fria11');

// Debug route to check API config
Route::get('/debug-api-config', function () {
    return response()->json([
        'api_url' => config('services.api.url'),
        'api_key' => config('services.api.key'),
        'auth_user' => Auth::user(),
        'csrf_token' => csrf_token()
    ]);
})->name('debug-api-config');


//Level: asesor
Route::middleware(['role:asesor'])->prefix('asesor')->group(function () {
    Route::get('/home', function () {
        return view('home/home-asesor/home-asesor');
    })->name('home-asesor');

    Route::get('/dashboard', function () {
        return view('home/home-asesor/asesor');
    })->name('asesor.dashboard');

    Route::get('/biodata', function () {
        return view('home/home-asesor/biodata');
    })->name('biodata-asesor');

    Route::get('/kompetensi', function () {
        return view('home/home-asesor/kompetensi');
    })->name('kompetensi-asesor');

    Route::get('/daftar-asesi', function () {
        return view('home/home-asesor/daftar-asesi');
    })->name('daftar-asesi');

    Route::get('/frapl02', function () {
        return view('home/home-asesor/frapl02-asesor');
    })->name('frapl02-asesor');

    Route::get('/frapl02/pdf/{id_asesi}', [\App\Http\Controllers\FRAPL02Controller::class, 'generatePdf'])->name('frapl02-print');

    Route::get('/frak01', function () {
        return view('home/home-asesor/frak01-asesor');
    })->name('frak01-asesor');

    Route::get('/frak01/pdf/{id_asesi}', [\App\Http\Controllers\FRAK01Controller::class, 'generatePdf'])->name('frak01-print');

    Route::get('/konsulprauji', function () {
        return view('home/home-asesor/konsul-prauji');
    })->name('konsul-prauji-asesor');
    Route::get('/konsul-prauji/pdf/{id_asesi}', [\App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen\KonsultasiPraUjiController::class, 'generatePdf'])->name('ketidakberpihakan.pdf');

    Route::get('/frmapa01', function () {
        return view('home/home-asesor/frmapa01');
    })->name('frmapa01-asesor');

    Route::get('/frmapa01/pdf/{id_asesi}', [\App\Http\Controllers\MAPA01Controller::class, 'generatePdf'])->name('mapa01-print');

    Route::get('/frmapa02', function () {
        return view('home/home-asesor/frmapa02');
    })->name('frmapa02-asesor');

    Route::get('/frmapa02/pdf/{id_asesi}', [\App\Http\Controllers\MAPA02Controller::class, 'generatePdf'])->name('mapa02-print');

    Route::get('/ketidakberpihakan', function () {
        return view('home/home-asesor/ketidakberpihakan');
    })->name('ketidakberpihakan-asesor');
    Route::get('/ketidakberpihakan/pdf/{id_asesi}', [\App\Http\Controllers\Api\Asesmen\PelaksanaanAsesmen\KetidakberpihakkanController::class, 'generatePdf'])->name('ketidakberpihakan.pdf');

    Route::get('/frak07', function () {
        return view('home/home-asesor/frak07-asesor');
    })->name('frak07-asesor');
    Route::get('/frak07/pdf/{id_asesi}', [\App\Http\Controllers\FRAK07Controller::class, 'generatePdf'])->name('frak07-print');

    Route::get('/fria01', [\App\Http\Controllers\IA01Controller::class, 'index'])->name('fria01-asesor');
    Route::post('/fria01/store', [\App\Http\Controllers\Fria01Controller::class, 'store'])->name('fria01.store');
    Route::get('/fria01/pdf/{id_asesi}', [\App\Http\Controllers\IA01Controller::class, 'generatePdf'])->name('fria01.pdf');

    Route::get('/fria02', function () {
        return view('home/home-asesor/fria02-asesor');
    })->name('fria02-asesor');
    Route::get('/fria02/pdf/{id_asesi}', [\App\Http\Controllers\Api\IA02Controller::class, 'generatePdf'])->name('fria02.pdf');

    Route::get('/fria03', function () {
        return view('home/home-asesor/fria03-asesor');
    })->name('fria03-asesor');

    Route::get('/fria05', function () {
        return view('home/home-asesor/fria05-asesor');
    })->name('fria05-asesor');

    Route::get('/fria07', [\App\Http\Controllers\IA07Controller::class, 'index'])->name('fria07-asesor');
    Route::post('/fria07/store', [\App\Http\Controllers\Fria07Controller::class, 'store'])->name('fria07.store');
    Route::post('/fria07/sign', [\App\Http\Controllers\Fria07Controller::class, 'signAsesor'])->name('fria07.sign');
    Route::get('/fria07/pdf/{id_asesi}', [\App\Http\Controllers\IA07Controller::class, 'generatePdf'])->name('fria07.pdf');

    Route::get('/tugas-peserta', [TugasPesertaController::class, 'index'])->name('tugas-peserta');
    Route::post('/tugas-peserta', [TugasPesertaController::class, 'store'])->name('tugas-peserta.store');
    Route::get('/tugas-peserta/pdf/{id_asesi}', [TugasPesertaController::class, 'generatePdf'])->name('tugas-peserta.pdf');
    Route::get('/tugas-peserta/download/{id}', [TugasPesertaController::class, 'downloadFile'])->name('tugas-peserta.download');
    Route::put('/tugas-peserta/status/{id}', [TugasPesertaController::class, 'updateTaskStatus'])->name('tugas-peserta.status');
    Route::post('/tugas-peserta/complete', [TugasPesertaController::class, 'completeAssessment'])->name('tugas-peserta.complete');

    Route::get('/fria11', [\App\Http\Controllers\IA11Controller::class, 'index'])->name('fria11-asesor');
    Route::post('/fria11/store', [\App\Http\Controllers\IA11Controller::class, 'store'])->name('fria11.store');
    Route::post('/fria11/sign', [\App\Http\Controllers\IA11Controller::class, 'sign'])->name('fria11.sign');

    Route::get('/hasilasesmen', [HasilAsesmenController::class, 'index'])->name('hasil-asesmen-asesor');

    Route::get('/frak02', function () {
        return view('home/home-asesor/frak02-asesor');
    })->name('frak02-asesor');

    Route::get('/frak03', function () {
        return view('home/home-asesor/frak03-asesor');
    })->name('frak03-asesor');

    Route::get('/frak04', [FRAK04Controller::class, 'index'])->name('frak04-asesor');
    Route::get('/frak04/{id_asesi}', [FRAK04Controller::class, 'show'])->name('frak04-asesor.show');

    // Skema Assessment Configuration for Asesor (Dynamic Assessment Flow)
    // Requirements: 2.1, 2.2, 2.3, 2.4
    Route::prefix('skema/{id}/assessment-config')->name('asesor.skema.assessment-config.')->group(function () {
        Route::get('/', [SkemaAssessmentConfigController::class, 'index'])->name('index');
        Route::put('/', [SkemaAssessmentConfigController::class, 'update'])->name('update');
    });

    // Dynamic Assessment Content Management for Asesor (Dynamic Assessment Flow)
    // Requirements: 4.1, 4.2, 4.3, 4.4, 4.5
    Route::prefix('assessment-content')->name('asesor.assessment-content.')->group(function () {
        Route::get('/{skemaId}/{type}', [DynamicContentController::class, 'index'])->name('index');
        Route::post('/', [DynamicContentController::class, 'store'])->name('store');
        Route::put('/{id}', [DynamicContentController::class, 'update'])->name('update');
        Route::delete('/{id}', [DynamicContentController::class, 'destroy'])->name('destroy');
    });

    // Scheme Context Selection for Dynamic Sidebar (Dynamic Assessment Flow)
    // Requirements: 6.1, 6.4
    Route::prefix('scheme-context')->name('asesor.scheme-context.')->group(function () {
        Route::get('/assigned', [SchemeContextController::class, 'getAssignedSchemes'])->name('assigned');
        Route::post('/set', [SchemeContextController::class, 'setSchemeContext'])->name('set');
        Route::post('/clear', [SchemeContextController::class, 'clearSchemeContext'])->name('clear');
        Route::get('/current', [SchemeContextController::class, 'getCurrentContext'])->name('current');
    });

    // Aksi Asesor
    Route::get('/aksi/aktif', function () {
        return view('home/home-asesor/aktif');
    })->name('asesor.aksi.aktif');

    Route::get('/aksi/tutup', function () {
        return view('home/home-asesor/tutup');
    })->name('asesor.aksi.tutup');

    // FRAK (Formulir Asesor)
    Route::prefix('frak')->group(function () {
        Route::get('/5', function () {
            return view('home/home-asesor/FRAK-05/frak05');
        })->name('asesor.frak.5');

        Route::get('/1', function () {
            return view('home/home-asesor/frak01');
        })->name('asesor.frak.1');
    });

    // Logout asesor
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});


// Global logout route for Jetstream components
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

//Guest (tanpa login)
Route::get('/', function () {
    return view('home/home');
})->name('home-visitor');

// Page autentikasi
Route::get('/login', function () {
    return view('home/home-visitor/login');
})->name('login');

// Page autentikasi
Route::get('/dev/login', function () {
    return view('home/home-visitor/dev-login');
})->name('dev-login');
Route::post('/dev/login', [LoginRegisterController::class, 'authenticate'])->name('login.post');

Route::get('/dev/register', function () {
    return view('home/home-visitor/dev-register');
})->name('dev-register');
Route::post('/dev/register', [LoginRegisterController::class, 'store'])->name('register.store');


// Login with Google
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');

// Page reset password
Route::get('/reset-password', function () {
    return view('auth/password/reset-password');
});
Route::get('/forget-password', function () {
    return view('auth/password/forget-password');
});
Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update'); // buat isi token

// Test Image Resize
Route::get('/test-resize', function () {
    return view('test-resize');
});

// Manual Image Test
Route::get('/test-manual-image', function () {
    return view('test-manual-image');
});

// URL Test route
Route::get('/test-url', function () {
    return view('test-url');
});

// Debug routes (remove in production)
Route::get('/debug-quill', function () {
    return view('debug-quill');
});

// Test routes (remove in production)
Route::get('/test-quill', function () {
    return view('test-quill');
});

// Quill.js Content Management Routes
Route::post('/upload-image', [IA02ContentController::class, 'uploadImage'])->name('upload.image');
Route::post('/save-content', [IA02ContentController::class, 'saveContent'])->name('save.content');
Route::get('/load-content/{ia02Id}/{contentType?}', [IA02ContentController::class, 'loadContent'])->name('load.content');
Route::delete('/delete-content/{ia02Id}/{contentType?}', [IA02ContentController::class, 'deleteContent'])->name('delete.content');

// Temporary Image Management Routes
// Route::post('/upload-temp-image', [TempImageController::class, 'uploadTempImage'])->name('upload.temp.image');
Route::post('/save-content-with-images', [IA02ContentController::class, 'saveContentWithImages'])->name('save.content.with.images');

// Legacy CKEditor routes (keep for backward compatibility)
Route::post('/save-instruksi-kerja', [HomeController::class, 'saveInstruksiKerja'])->name('save.instruksi');

// Emergency file upload route without middleware (temporary fix for serialization issue)
Route::post('/emergency-tugas-upload', [FileUploadController::class, 'uploadTask'])->name('emergency.tugas.store');
Route::get('/test-upload-method', [FileUploadController::class, 'uploadTask'])->name('test.upload');

// Page informasi
Route::get('/panduan', function () {
    return view('home/home-visitor/panduan');
})->name('panduan');
Route::get('/profile', function () {
    return view('home/home-visitor/profile');
});
Route::get('/skema', [HomeController::class, 'index'])->name('skema');
