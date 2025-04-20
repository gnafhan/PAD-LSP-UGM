<?php
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

//Level: user
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
        Route::get('/b1', function () {
            return view('home/home-visitor/APL-01/data-pribadi');
        })->name('pribadi');
        Route::post('/save-data-pribadi', [PengajuanController::class, 'saveDataPribadi']);

        Route::get('/b2', [PengajuanController::class, 'showDataSertifikasi'])->name('sertifikasi');
        Route::get('/get-nomor-skema', [PengajuanController::class, 'getNomorSkema']);
        Route::get('/get-daftar-uk', [PengajuanController::class, 'showDaftarUK']);
        Route::post('/save-data-sertifikasi', [PengajuanController::class, 'saveDataSertifikasi'])->name('save-data-sertifikasi');

        Route::get('/b3', function () {
            return view('home/home-visitor/APL-01/bukti-pemohon');
        })->name('bukti');

        Route::get('/b4', function () {
            return view('home/home-visitor/APL-01/konfirmasi');
        })->name('konfirmasi');

        Route::post('/save-data-pengajuan', [PengajuanController::class, 'storePengajuan'])->name('save');
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
        Route::delete('{id}', [SkemaPageController::class, 'destroyDataSkema'])->name('delete');
    });

    // Manajemen Unit Kompetensi (UK)
    Route::prefix('uk')->name('admin.uk.')->group(function () {
        Route::get('/', [UnitKompetensiPageController::class, 'indexDataUk'])->name('index');
        Route::get('create', [UnitKompetensiPageController::class, 'createDataUk'])->name('create');
        Route::get('getUK', [UnitKompetensiPageController::class, 'getUK'])->name('getUK');
        Route::post('create', [UnitKompetensiPageController::class, 'storeDataUk'])->name('store');
        Route::get('{id}/edit', [UnitKompetensiPageController::class, 'editDataUk'])->name('edit');
        Route::put('{id}/update', [UnitKompetensiPageController::class, 'updateDataUk'])->name('update');
        Route::delete('{id}', [UnitKompetensiPageController::class, 'destroyDataUk'])->name('delete');
    });

    // Manajemen Rencana Asesmen
    Route::prefix('skema/{id_skema}/rencana-asesmen')->name('admin.skema.rencana-asesmen.')->group(function () {
        Route::get('/', [RencanaAsesmenController::class, 'index'])->name('index');
        Route::get('/uk/{id_uk}', [RencanaAsesmenController::class, 'getByUK'])->name('getByUK');
        Route::post('/store', [RencanaAsesmenController::class, 'store'])->name('store');
        Route::post('/generate/{id_uk}', [RencanaAsesmenController::class, 'generateFromElemen'])->name('generate');
        Route::delete('/{id_rencana_asesmen}', [RencanaAsesmenController::class, 'destroy'])->name('destroy');
    });

    // Manajemen Event
    Route::prefix('event')->name('admin.event.')->group(function () {
        Route::get('/', [AdminController::class, 'indexDataEvent'])->name('index');
        Route::get('create', [AdminController::class, 'createDataEvent'])->name('create');
        Route::post('create', [AdminController::class, 'storeDataEvent'])->name('store');
        Route::get('{id}/edit', [AdminController::class, 'editDataEvent'])->name('edit');
        Route::put('{id}/update', [AdminController::class, 'updateDataEvent'])->name('update');
        Route::delete('{id}', [AdminController::class, 'destroyDataEvent'])->name('delete');
    });

    // Manajemen Asesi
    Route::prefix('asesi')->name('admin.asesi.')->group(function () {
        Route::get('/', [AsesiPengajuanPageController::class, 'indexDataAsesi'])->name('index');
        Route::get('{id}/edit', [AsesiPengajuanPageController::class, 'detailDataAsesi'])->name('detail');
        Route::post('approve/{id_pengajuan}', [AsesiPengajuanPageController::class, 'approveAsesi'])->name('approve');
        // Get asesor berdasarkan bidang kompetensi
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
            Route::delete('{id}', [AdminUserController::class, 'destroy'])->name('destroy');
        });

        // Asesor Management
        Route::prefix('asesor')->name('asesor.')->group(function () {
            Route::get('create', [AsesorController::class, 'create'])->name('create');
            Route::post('store', [AsesorController::class, 'store'])->name('store');
            Route::get('{id}/edit', [AsesorController::class, 'edit'])->name('edit');
            Route::put('{id}/update-status', [AsesorController::class, 'updateStatus'])->name('update-status');
            Route::get('{id}', [AsesorController::class, 'show'])->name('show');
            Route::delete('{id}', [AsesorController::class, 'destroy'])->name('destroy');
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

// HOME  ASESI SETELAH MELAKUKAN REGISTER
Route::get('/register', function () {
    return view('home/home-visitor/register');})->name('register');
Route::get('/login', function () {
    return view('home/home-visitor/login');})->name('login');

Route::post('/register', [LoginRegisterController::class, 'store'])->name('register.store');
Route::post('/login', [LoginRegisterController::class, 'authenticate'])->name('login.post');

Route::get('/home', function () {
    return view('home/home-visitor/home');
})->name('home');

Route::post('admin/asesor', [AdminController::class, 'storeDataAsesor'])->name('admin.asesor.store');
Route::get('/admin5', [AdminController::class, 'indexDataAsesor'])->name('admin.asesor.index');
Route::get('/admin5/{id}/edit', [AdminController::class, 'editDataAsesor'])->name('admin.asesor.edit');
Route::put('/admin5/{id}/update', [AdminController::class, 'updateDataAsesor'])->name('admin.asesor.update');
Route::delete('/admin5/{id}', [AdminController::class, 'destroyDataAsesor'])->name('admin.asesor.delete');

Route::get('/admin3', [AdminController::class, 'indexDataSkema'])->name('admin.skema.index');
Route::get('/admin3/create', [AdminController::class, 'createDataSkema'])->name('admin.skema.create'); //karena perlu data uk
Route::post('/admin3/create', [AdminController::class, 'storeDataSkema'])->name('admin.skema.store');
Route::get('/admin3/{id}/edit', [AdminController::class, 'editDataSkema'])->name('admin.skema.edit');
Route::put('/admin3/{id}/update', [AdminController::class, 'updateDataSkema'])->name('admin.skema.update');
Route::delete('/admin3/{id}', [AdminController::class, 'destroyDataSkema'])->name('admin.skema.delete');

Route::get('/admin7', [AdminController::class, 'indexDataUk'])->name('admin.uk.index');
Route::get('/admin7/create', [AdminController::class, 'createDataUk'])->name('admin.uk.create');
Route::post('/admin7/create', [AdminController::class, 'storeDataUk'])->name('admin.uk.store');
Route::get('/admin7/{id}/edit', [AdminController::class, 'editDataUk'])->name('admin.uk.edit');
Route::put('/admin7/{id}/update', [AdminController::class, 'updateDataUk'])->name('admin.uk.update');
Route::delete('/admin7/{id}', [AdminController::class, 'destroyDataUk'])->name('admin.uk.delete');

Route::get('/admin2', [AdminController::class, 'indexDataEvent'])->name('admin.event.index');
Route::get('/admin2/create', [AdminController::class, 'createDataEvent'])->name('admin.event.create'); //karena perlu data skema
Route::post('/admin2/create', [AdminController::class, 'storeDataEvent'])->name('admin.event.store');
Route::get('/admin2/{id}/edit', [AdminController::class, 'editDataEvent'])->name('admin.event.edit');
Route::put('/admin2/{id}/update', [AdminController::class, 'updateDataEvent'])->name('admin.event.update');
Route::delete('/admin2/{id}', [AdminController::class, 'destroyDataEvent'])->name('admin.event.delete');

Route::get('/admin4', [AdminController::class, 'indexDataAsesi'])->name('admin.asesi.index');
Route::get('/admin4/{id}/edit', [AdminController::class, 'detailDataAsesi'])->name('admin.detail.asesi');
Route::post('/admin4/approve-asesi/{id_pengajuan}', [AdminController::class, 'approveAsesi'])->name('admin.approve.asesi');
Route::post('/assign-asesor', [AdminController::class, 'assignAsesor'])->name('assign.asesor');

Route::get('/pengguna', function () {
    return view('home/home-admin/pengguna');
});

Route::get('/tambah-pengguna', function () {
    return view('home/home-admin/tambah-pengguna');
});

// HOME - ASESI
// Route::get('/home-asesi', function () {
//     return view('home/home-asesi/home-asesi');
// });

Route::get('/assesi', function () {
    return view('home/home-asesi/assesi');
});

Route::get('/apl2', [AsesiController::class, 'asesmenMandiri'])->name('asesmen.mandiri');

// ALUR FR.APL-01
Route::get('/apl1/1', function () {
    return view('home/home-asesi/APL-01/data-pribadi');
});
Route::get('/apl1/2', function () {
    return view('home/home-asesi/APL-01/data-sertifikasi');
});
Route::get('/apl1/3', function () {
    return view('home/home-asesi/APL-01/bukti-pemohon');
});
Route::get('/apl1/4', function () {
    return view('home/home-asesi/APL-01/konfirmasi');
});

// Bagian 1 APL-01 yang sudah ada data pekerjaan sekarang
Route::get('/apl1/bg1', function () {
    return view('home/home-visitor/APL-01/bagian1');
});
// BAGIAN PILIH AKSI HOME -ASESI

Route::get('/aksi', function () {
    return view('home/home-asesi/pilih-aksi');
});

Route::get('/persetujuan', function () {
    return view('home/home-asesi/persetujuan');
});

Route::get('/ak1', function () {
    return view('home/home-asesi/FRAK-01/frak01');
});

Route::get('/ak3', function () {
    return view('home/home-asesi/FRAK-03/frak3');
});

Route::get('/ia2', function () {
    return view('home/home-asesi/FRIA-02/soal-praktek-upload-jawaban');
});



// HOME - ASESOR
Route::get('/home-asesor', function () {
    return view('home/home-asesor/home-asesor');
})->name('home-asesor');
Route::get('/asesor1', function () {
    return view('home/home-asesor/asesor');
});
Route::get('/aksi2', function () {
    return view('home/home-asesor/aktif');
});
Route::get('/aksi3', function () {
    return view('home/home-asesor/tutup');
});
Route::get('/frak5', function () {
    return view('home/home-asesor/FRAK-05/frak05');
});

Route::get('/home-admin', [AdminController::class, 'index'])->name('home-admin');
Route::get('/btn-asesi', function () {
    return view('home/home-admin/button-asesi');
});
Route::get('/assign-asesor', function () {
    return view('home/home-admin/assign-asesor');
});
// Route::get('/admin4', function () {
//     return view('home/home-admin/daftar-asesi');
// });

Route::get('/admin6', function () {
    return view('home/home-admin/settings');
});
Route::get('/form', function () {
    return view('home/home-admin/form-asesor');
});
Route::get('/dp', function () {
    return view('home/home-admin/detail-pengajuan');
});
Route::get('/frak1', function () {
    return view('home/home-asesor/frak01');
});

//testing forget password
Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update'); // buat isi token pake post

// //testing home-asesi
Route::get('/home-asesi', [AsesiController::class, 'index'])->name('home-asesi');
Route::get('/assesi', [AsesiController::class, 'indexAssesi'])->name('assesi');


Route::get('/persetujuan/ttd', [PengajuanController::class, 'indexPersetujuan'])->name('persetujuan');
Route::post('/save-data-persetujuan', [PengajuanController::class, 'saveDataPersetujuan'])->name('save.persetujuan');

Route::get('/apl1/b1', function () {
    return view('home/home-visitor/APL-01/data-pribadi');
})->name('pribadi');
Route::post('/save-data-pribadi', [PengajuanController::class, 'saveDataPribadi']);

Route::get('/apl1/b2', function () {
    return view('home/home-visitor/APL-01/data-sertifikasi');
});

Route::get('/apl1/b2', [PengajuanController::class, 'showDataSertifikasi'])->name('sertifikasi');
Route::get('/get-nomor-skema', [PengajuanController::class, 'getNomorSkema']);
Route::get('/get-daftar-uk', [PengajuanController::class, 'showDaftarUK']);
Route::post('/save-data-sertifikasi', [PengajuanController::class, 'saveDataSertifikasi'])->name('save.data.sertifikasi');

Route::post('/save-data-pengajuan', [PengajuanController::class, 'storePengajuan'])->name('save');
Route::get('/apl1/b3', function () {
    return view('home/home-visitor/APL-01/bukti-pemohon');
})->name('bukti');

Route::get('/apl1/b4', function () {
    return view('home/home-visitor/APL-01/konfirmasi');
})->name('konfirmasi');



Route::get('/', function () {
    return view('home/home');
});

Route::get('/masuk', function () {
    return view('home/home-visitor/masuk');
});


// Route::get('/assesi', function () {
//     return view('home/home-asesi/assesi');
// });

Route::get('/aksi', function () {
    return view('home/home-asesi/pilih-aksi');
});

Route::get('/ak1', function () {
    return view('home/home-asesi/FRAK-01/frak01');
});

Route::get('/ak3', function () {
    return view('home/home-asesi/FRAK-03/frak3');
});

Route::get('/ia2', function () {
    return view('home/home-asesi/FRIA-02/soal-praktek-upload-jawaban');
});

Route::get('/jadwal-uji-kompetensi', function () {
    return view('home/home-asesi/APL-02/jadwal-uji-kompetensi');
});

// Route::get('/apl2', function () {
//     return view('home/home-asesi/APL-02/asesmen-mandiri');
// });

Route::get('/admin6', function () {
    return view('home/home-admin/settings');
});
Route::get('/form', function () {
    return view('home/home-admin/form-asesor');
});
Route::get('/dp', function () {
    return view('home/home-admin/detail-pengajuan');
});
Route::get('/frak1', function () {
    return view('home/home-asesor/frak01');
});


Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update'); // buat isi token pake post
