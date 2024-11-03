<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AsesiController;

Route::get('/', function () {
    return view('home/home');
});
Route::get('/masuk', function () {
    return view('masuk');
});

// Opsi Login Pertama
Route::get('/loginasesi', function () {
    return view('loginasesi');
});
Route::get('/loginasesor', function () {
    return view('loginasesor');
});
Route::get('/loginadmin', function () {
    return view('loginadmin');
});

// Opsi login kedua
// asesi tetep make opsi pertama
Route::get('/asesor', function () {
    return view('loginasesor');
});
Route::get('/admin', function () {
    return view('loginadmin');
});

//home visitor
Route::get('/register', function () {
    return view('register');
});
Route::get('/reset-password', function () {
    return view('auth/password/reset-password');
});
Route::get('/forget-password', function () {
    return view('auth/password/forget-password');
});
Route::get('/panduan', function () {
    return view('home/panduan');
});
Route::get('/profile', function () {
    return view('home/profile');
});

//home asesi
Route::get('/home-asesi', function () {
    return view('home-asesi/home-asesi');
});

Route::get('/assesi', function () {
    return view('home-asesi/assesi');
});

// Bagian Pilih Aksi

Route::get('/aksi', function () {
    return view('home-asesi/pilih-aksi');
});

Route::get('/persetujuan', function () {
    return view('home-asesi/persetujuan');
});

Route::get('/ak1', function () {
    return view('home-asesi/FRAK-01/frak01');
});

Route::get('/ak3', function () {
    return view('home-asesi/FRAK-03/frak3');
});

Route::get('/ia2', function () {
    return view('home-asesi/FRIA-02/soal-praktek-upload-jawaban');
});

Route::get('/jadwal-uji-kompetensi', function () {
    return view('home-asesi/jadwal-uji-kompetensi');
});

Route::get('/apl2', function () {
    return view('home-asesi/APL-02/asesmen-mandiri');
});

// Bagian FR.AK APL - 01
Route::get('/apl1/b2', function () {
    return view('home-asesi/APL-01/data-sertifikasi');
});
Route::get('/apl1/b1', function () {
    return view('home-asesi/APL-01/data-pribadi');
});
Route::get('/apl1/b3', function () {
    return view('home-asesi/APL-01/bukti-pemohon');
});
Route::get('/apl1/b4', function () {
    return view('home-asesi/APL-01/konfirmasi');
});


//testing login yak
Route::get('/loginasesi', function () {
    return view('loginasesi');
})->name('login.form');

Route::post('/loginasesi', [LoginController::class, 'login'])->name('login.post');

Route::get('/home', function () {
    return view('home/home');
})->name('home');

//testing forget password
Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update'); // buat isi token pake post

//testing home-asesi
Route::get('/home-asesi', [AsesiController::class, 'index'])->middleware('auth');
Route::post('/data-pengajuan', [AsesiPengajuanController::class, 'storeDataPengajuan'])->name('data-pengajuan');
Route::post('/profile-peserta', [AsesiPengajuanController::class, 'storeProfilePeserta'])->name('profile-peserta');
Route::post('/dokumen-portofolio', [AsesiPengajuanController::class, 'storeDokumenPortofolio'])->name('dokumen-portofolio');
