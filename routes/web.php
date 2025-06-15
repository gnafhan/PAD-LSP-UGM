<?php
use App\Http\Controllers\Admin\ManajemenEvent\EventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AsesiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ManajemenAssignAsesiToAsesor\AsesiPengajuanPageController;
use App\Http\Controllers\Admin\ManajemenSkema\SkemaPageController;
use App\Http\Controllers\Admin\ManajemenUnitKompetensi\UnitKompetensiPageController;
use App\Http\Controllers\Admin\ManajemenSkema\RencanaAsesmenController;
use App\Http\Controllers\Admin\ManajemenPengguna\PenggunaPageController;
use App\Http\Controllers\Admin\ManajemenPengguna\AsesorController;
use App\Http\Controllers\Admin\ManajemenPengguna\AdminUserController;
use App\Http\Controllers\Admin\ManajemenPengguna\KompetensiTeknisController;
use App\Http\Controllers\Admin\ManajemenTUK\TukController;
use App\Http\Controllers\Admin\ManajemenTUK\PenanggungJawabController;
use App\Http\Controllers\SwaggerController;


// API Documentation
Route::get('api/documentation', [SwaggerController::class, 'index'])
    ->name('l5-swagger.default.api');

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

    // Manajemen Rencana Asesmen
    Route::prefix('skema/{id_skema}/rencana-asesmen')->name('admin.skema.rencana-asesmen.')->group(function () {
        Route::get('/', [RencanaAsesmenController::class, 'index'])->name('index');
        Route::get('/uk/{id_uk}', [RencanaAsesmenController::class, 'getByUK'])->name('getByUK');
        Route::post('/store', [RencanaAsesmenController::class, 'store'])->name('store');
        Route::post('/generate/{id_uk}', [RencanaAsesmenController::class, 'generateFromElemen'])->name('generate');
        Route::delete('/{id_rencana_asesmen}', [RencanaAsesmenController::class, 'destroy'])->name('destroy');
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
        Route::post('/pengajuan/{id_pengajuan}/revisi', [AsesiPengajuanPageController::class, 'requestRevision'])->name('request.revision');
    });

    // Manajemen Asesor untuk Asesi untuk fitur dependent dropdown list
    Route::post('assign-asesor', [AsesiPengajuanPageController::class, 'assignAsesor'])->name('assign.asesor');
    Route::get('get-asesor-by-bidang/{id_bidang}', [AsesiPengajuanPageController::class, 'getAsesorByBidang'])->name('get.asesor.by.bidang');
    Route::get('get-all-asesor', [AsesiPengajuanPageController::class, 'getAllAsesor'])->name('get.all.asesor');


    // Manajemen Pengguna
    Route::prefix('pengguna')->name('admin.pengguna.')->group(function () {
        // Dashboard Pengguna (Main view)
        Route::get('/', [PenggunaPageController::class, 'index'])->name('index');
        Route::get('tambah-pengguna', [PenggunaPageController::class, 'create'])->name('create');

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

    // APL-02 Asesmen Mandiri
    Route::get('/apl2', [AsesiController::class, 'asesmenMandiri'])->name('asesi.asesmen.mandiri');

    // ALUR FR.APL-01
    Route::get('/apl1/{id}', [AsesiController::class, 'detailApl1'])->name('asesi.apl1-detail');

    // Pilih Aksi Home Asesi
    Route::view('/aksi', 'home/home-asesi/pilih-aksi')->name('asesi.pilih-aksi');
    Route::view('/persetujuan', 'home/home-asesi/persetujuan')->name('asesi.persetujuan');

    // FRAK-01, FRAK-03, FRIA-02
    Route::prefix('fr')->name('asesi.fr.')->group(function () {
        Route::view('/ak1', 'home/home-asesi/FRAK-01/frak01')->name('ak1');
        Route::view('/ak3', 'home/home-asesi/FRAK-03/frak3')->name('ak3');
        Route::view('/ia2', 'home/home-asesi/FRIA-02/soal-praktek-upload-jawaban')->name('ia2');
    });

    // Jadwal Uji Kompetensi
    Route::view('/jadwal-uji-kompetensi', 'home/home-asesi/APL-02/jadwal-uji-kompetensi')->name('asesi.jadwal-uji-kompetensi');

    // Logout asesi
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});


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

    Route::get('/frak01', function () {
        return view('home/home-asesor/frak01-asesor');
    })->name('frak01-asesor');

    Route::get('/konsulprauji', function () {
        return view('home/home-asesor/konsul-prauji');
    })->name('konsul-prauji-asesor');

    Route::get('/frmapa01', function () {
        return view('home/home-asesor/frmapa01');
    })->name('frmapa01-asesor');

    Route::get('/frmapa02', function () {
        return view('home/home-asesor/frmapa02');
    })->name('frmapa02-asesor');

    Route::get('/ketidakberpihakan', function () {
        return view('home/home-asesor/ketidakberpihakan');
    })->name('ketidakberpihakan-asesor');

    Route::get('/frak07', function () {
        return view('home/home-asesor/frak07-asesor');
    })->name('frak07-asesor');

    Route::get('/fria01', function () {
        return view('home/home-asesor/fria01-asesor');
    })->name('fria01-asesor');

    Route::get('/fria02', function () {
        return view('home/home-asesor/fria02-asesor');
    })->name('fria02-asesor');

    Route::get('/fria03', function () {
        return view('home/home-asesor/fria03-asesor');
    })->name('fria03-asesor');

    Route::get('/fria05', function () {
        return view('home/home-asesor/fria05-asesor');
    })->name('fria05-asesor');

    Route::get('/fria07', function () {
        return view('home/home-asesor/fria07-asesor');
    })->name('fria07-asesor');

    Route::get('/hasilasesmen', function () {
        return view('home/home-asesor/hasil-asesmen');
    })->name('hasil-asesmen-asesor');

    Route::get('/frak02', function () {
        return view('home/home-asesor/frak02-asesor');
    })->name('frak02-asesor');

    Route::get('/frak03', function () {
        return view('home/home-asesor/frak03-asesor');
    })->name('frak03-asesor');

    Route::get('/frak04', function () {
        return view('home/home-asesor/frak04-asesor');
    })->name('frak04-asesor');

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


//Guest (tanpa login)
Route::get('/', function () {
    return view('home/home');
});

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

// Page informasi
Route::get('/panduan', function () {
    return view('home/home-visitor/panduan');
});
Route::get('/profile', function () {
    return view('home/home-visitor/profile');
});
Route::get('/skema', [HomeController::class, 'index'])->name('skema');
