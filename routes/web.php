<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AsesiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\HomeController;


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

    // Manajemen Asesor
    Route::prefix('asesor')->name('admin.asesor.')->group(function () {
        Route::post('/', [AdminController::class, 'storeDataAsesor'])->name('store');
        Route::get('/', [AdminController::class, 'indexDataAsesor'])->name('index');
        Route::get('{id}/edit', [AdminController::class, 'editDataAsesor'])->name('edit');
        Route::put('{id}/update', [AdminController::class, 'updateDataAsesor'])->name('update');
        Route::delete('{id}', [AdminController::class, 'destroyDataAsesor'])->name('delete');
    });

    // Manajemen Skema
    Route::prefix('skema')->name('admin.skema.')->group(function () {
        Route::get('/', [AdminController::class, 'indexDataSkema'])->name('index');
        Route::get('create', [AdminController::class, 'createDataSkema'])->name('create');
        Route::post('create', [AdminController::class, 'storeDataSkema'])->name('store');
        Route::get('{id}/edit', [AdminController::class, 'editDataSkema'])->name('edit');
        Route::put('{id}/update', [AdminController::class, 'updateDataSkema'])->name('update');
        Route::delete('{id}', [AdminController::class, 'destroyDataSkema'])->name('delete');
    });

    // Manajemen Unit Kompetensi (UK)
    Route::prefix('uk')->name('admin.uk.')->group(function () {
        Route::get('/', [AdminController::class, 'indexDataUk'])->name('index');
        Route::get('create', [AdminController::class, 'createDataUk'])->name('create');
        Route::post('create', [AdminController::class, 'storeDataUk'])->name('store');
        Route::get('{id}/edit', [AdminController::class, 'editDataUk'])->name('edit');
        Route::put('{id}/update', [AdminController::class, 'updateDataUk'])->name('update');
        Route::delete('{id}', [AdminController::class, 'destroyDataUk'])->name('delete');
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
        Route::get('/', [AdminController::class, 'indexDataAsesi'])->name('index');
        Route::get('{id}/edit', [AdminController::class, 'detailDataAsesi'])->name('detail');
        Route::post('approve/{id_pengajuan}', [AdminController::class, 'approveAsesi'])->name('approve');
    });

    // Manajemen Asesor untuk Asesi
    Route::post('assign-asesor', [AdminController::class, 'assignAsesor'])->name('assign.asesor');

    // Tampilan yg tidak ada backend
    Route::get('/pengguna', function () {
        return view('home.home-admin.pengguna');
    });
    Route::get('/tambah-pengguna', function () {
        return view('home.home-admin.tambah-pengguna');
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
Route::post('/login', [LoginRegisterController::class, 'authenticate'])->name('login.post');

Route::get('/register', function () {
    return view('home/home-visitor/register');
})->name('register');
Route::post('/register', [LoginRegisterController::class, 'store'])->name('register.store');

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
