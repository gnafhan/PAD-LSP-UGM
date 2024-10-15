<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

Route::get('/register', function () {
    return view('register');
});
Route::get('/reset-password', function () {
    return view('auth/password/reset-password');
});
Route::get('/forget-password', function () {
    return view('auth/password/forget-password');
});

//testing login yak
Route::get('/loginasesi', function () {
    return view('loginasesi');
})->name('login.form');

Route::post('/loginasesi', [LoginController::class, 'login'])->name('login.post');

Route::get('/home', function () {
    return view('home');
})->name('home');
