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
Route::get('/jadwal-uji-kompetensi', function () {
    return view('home-asesi/jadwal-uji-kompetensi');
});
Route::get('/data-pengajuan', function () {
    return view('home-asesi/data-pengajuan');
});
Route::get('/profile-peserta', function () {
    return view('home-asesi/profile-peserta');
});
Route::get('/konfirmasi', function () {
    return view('home-asesi/konfirmasi');
});
Route::get('/dokumen-portofolio', function () {
    return view('home-asesi/dokumen-portofolio');
});
Route::get('/asesmen-mandiri', function () {
    return view('home-asesi/asesmen-mandiri');
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
