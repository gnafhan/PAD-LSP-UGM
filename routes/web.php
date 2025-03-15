<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AsesiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\HomeController;


// Guest (tanpa login)
Route::get('/', function () {
    return view('home/home');
});

// Page autentikasi
Route::get('/login', function () {
    return view('home/home-visitor/login');
})->name('login');
Route::get('/register', function () {
    return view('home/home-visitor/register');
})->name('register');
Route::post('/register', [LoginRegisterController::class, 'store'])->name('register.store');
Route::post('/login', [LoginRegisterController::class, 'authenticate'])->name('login.post');
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Page reset password
Route::get('/reset-password', function () {
    return view('auth/password/reset-password');
});
Route::get('/forget-password', function () {
    return view('auth/password/forget-password');
});

// Page informasi
Route::get('/panduan', function () {
    return view('home/home-visitor/panduan');
});
Route::get('/profile', function () {
    return view('home/home-visitor/profile');
});
Route::get('/skema', [HomeController::class, 'index'])->name('skema');



//harus login level user
Route::get('/home', function () {
    return view('home/home-visitor/home');
})->name('home');


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



//UJI COBA ADMIN
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
    // Route::view('pengguna', 'home.home-admin.pengguna');
    // Route::view('tambah-pengguna', 'home.home-admin.tambah-pengguna');
});


// Route::get('/form', function () {
// return view('home/home-admin/form-asesor');
// });
// Route::get('/dp', function () {
// return view('home/home-admin/detail-pengajuan');
// });

// Route::get('/assign-asesor', function () {
//     return view('home/home-admin/assign-asesor');
// });



// //testing home-asesi
Route::get('/home-asesi', [AsesiController::class, 'index'])->name('home-asesi');
Route::get('/assesi', [AsesiController::class, 'indexAssesi'])->name('assesi');

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
Route::get('/frak1', function () {
    return view('home/home-asesor/frak01');
    });



Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update'); // buat isi token pake post
//testing forget password
Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update'); // buat isi token pake post
