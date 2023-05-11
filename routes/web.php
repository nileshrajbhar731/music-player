<?php

use App\Http\Controllers\MusicAnalysisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\BasicController;

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

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/login', function () {
//     return view('login');
// });
// Route::get('/signin', function () {
//     return view('signIn');
// });
Route::get('/aboutUs', function () {
    return view('aboutUs');
});
Route::get('/contactUs', function () {
    return view('contactUs');
});
// login and sign in

Route::get('/login', [BasicController::class, 'login']);
Route::post('/login/auth', [BasicController::class, 'auth']);
Route::get('/signin', [BasicController::class, 'signin']);
Route::post('signin/store', [BasicController::class, 'store']);
// 
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/logOut', [GoogleController::class, 'logout']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::get('/dashboard', [FileUploadController::class, 'musicList']);
Route::get('/deleteFile/files/{filename}', [FileUploadController::class, 'deleteFile']);



Route::get('/profile', [GoogleController::class, 'Profile']);

// 
// Route::get('/music-analysis', function () {
//     return view('musicAnalysis');
// });
Route::get('upload-file', [FileUploadController::class, 'index']);
Route::post('store', [FileUploadController::class, 'store']);

// Route::get('/youtube-link', function () {
//     return view('youtubeLink');
// });
Route::get('youtube-link', [FileUploadController::class, 'YoutubeLink']);
Route::post('youtube-store', [FileUploadController::class, 'YoutubeStore']);
// ---
Route::get('audio/files/{file}',  [FileUploadController::class, 'stream']);

// 

Route::get('music-analysis',  [MusicAnalysisController::class, 'pieChart']);

Route::get('song-like',  [SongController::class, 'index']);
Route::get('song-like-store/{id}',  [SongController::class, 'store']);

Route::get('likeRemove/{id}',  [SongController::class, 'likeRemove']);



