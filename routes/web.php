<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginRegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AsesiController;
use App\Http\Controllers\PengajuanController;

Route::get('/apl1/b2', [PengajuanController::class, 'showDataSertifikasi'])->name('sertifikasi');
Route::get('/get-nomor-skema', [PengajuanController::class, 'getNomorSkema']);
Route::get('/get-daftar-uk', [PengajuanController::class, 'showDaftarUK']);

Route::post('/save-data-pribadi', [PengajuanController::class, 'saveDataPribadi']);
Route::post('/save-data-sertifikasi', [PengajuanController::class, 'saveDataSertifikasi']);
Route::post('/apl1/kirim', [PengajuanController::class, 'storePengajuan']);

Route::get('/apl1/b3', function () {
    return view('home/home-asesi/APL-01/bukti-pemohon');
})->name('bukti');
Route::get('/apl1/b4', function () {
    return view('home/home-asesi/APL-01/konfirmasi');
})->name('konfirmasi');



Route::get('/', function () {
    return view('home/home');
});

Route::get('/masuk', function () {
    return view('home/home-visitor/masuk');
});

// VISITOR
Route::get('/register', function () {
    return view('home/home-visitor/register');
});
Route::get('/reset-password', function () {
    return view('auth/password/reset-password');
});
Route::get('/forget-password', function () {
    return view('auth/password/forget-password');
});
Route::get('/panduan', function () {
    return view('home/home-visitor/panduan');
});
Route::get('/profile', function () {
    return view('home/home-visitor/profile');
});

// VISITOR BAGIAN LOGIN USER
Route::get('/login', function () {
    return view('home/home-visitor/login');
})->name('login');
// Route::get('/loginasesor', function () {
//     return view('home/home-visitor/loginasesor');
// });
// Route::get('/loginadmin', function () {
//     return view('home/home-visitor/loginadmin');
// });

// Opsi login kedua
// asesi tetep make opsi pertama
Route::get('/asesor', function () {
    return view('home/home-visitor/loginasesor');
});
Route::get('/admin', function () {
    return view('home/home-visitor/loginadmin');
});

// ASESI
Route::get('/home-asesi', function () {
    return view('home/home-asesi/home-asesi');
});

Route::get('/assesi', function () {
    return view('home/home-asesi/assesi'); //tampilan asesi skema yg pernah diikuti dan sdg diikuti
});

// BAGIAN PILIH AKSI

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

Route::get('/jadwal-uji-kompetensi', function () {
    return view('home/home-asesi/APL-02/jadwal-uji-kompetensi');
});

Route::get('/apl2', function () {
    return view('home/home-asesi/APL-02/asesmen-mandiri');
});

// Bagian Pilih Aksi FR.AK APL - 01
Route::get('/apl1/b1', function () {
    return view('home/home-asesi/APL-01/data-pribadi');
});
// Route::get('/apl1/b2', function () {
//     return view('home/home-asesi/APL-01/data-sertifikasi');
// });  //kalo udah di get pake controller, ternyata gabisa di get untuk return view juga bel
// Route::get('/apl1/b3', function () {
//     return view('home/home-asesi/APL-01/bukti-pemohon');
// });
// Route::get('/apl1/b4', function () {
//     return view('home/home-asesi/APL-01/konfirmasi');
// })->name('konfirmasi');

// Asesor
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


// Admin
Route::get('/home-admin', function () {
    return view('home/home-admin/home');
})->name('home-admin');
Route::get('/admin2', function () {
    return view('home/home-admin/event');
});
Route::get('/admin3', function () {
    return view('home/home-admin/skema');
});
Route::get('/admin4', function () {
    return view('home/home-admin/daftar-asesi');
});
Route::get('/admin5', function () {
    return view('home/home-admin/daftar-asesor');
});
Route::get('/admin6', function () {
    return view('home/home-admin/settings');
});
Route::get('/form', function () {
    return view('home/home-admin/form-asesor');
});


Route::get('/register', function () {
    return view('home/home-visitor/register');})->name('register.form');

Route::post('/register', [LoginRegisterController::class, 'store'])->name('register.store');
Route::post('/login', [LoginRegisterController::class, 'authenticate'])->name('login.post');

Route::get('/login', function () {
    return view('home/home-visitor/login');
})->name('login');

Route::get('/home', function () {
    return view('home/home-visitor/home');
})->name('home');

//testing forget password
Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update'); // buat isi token pake post

// //testing home-asesi
Route::get('/home-asesi', [AsesiController::class, 'index'])->middleware('auth');


