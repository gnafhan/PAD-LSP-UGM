<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
Route::get('/products', [ProductController::class, 'index']);

use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/about', function () {
//     return view('contents.about', [
//         "name" => "lala",
//         "email" => "lala@gmail.com"
//     ]);
// });

// Route::get('/dashboard', function () {
//     return view('contents.dashboard');
// });

// Route::get('/headerFooter', function () {
//     return view('folderLayout.headerFooter');
// });

// Route::get('/layout', function () {
//     return view('folderLayout.layout');
// });

// Route::get('/about', function () {
//     return view('contents.about');
// })->name('about');

// P3
// Route::get('/posts', function () {
//     return view('posts');
// });

Route::get('/posts', [PostController::class, 'index']);