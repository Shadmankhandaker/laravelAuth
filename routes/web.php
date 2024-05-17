<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Home Page
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Facebook OAuth Routes
//Route::get('/auth/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook', [TestController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [TestController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

//Route::get('/test-facebook', [App\Http\Controllers\TestController::class, 'testFacebook'])->name('testFacebook');
Route::get('/test-facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('testFacebook');

Route::get('auth/twitter', [TestController::class, 'redirectToTwitter'])->name('auth.twitter');
Route::get('auth/twitter/callback', [TestController::class, 'handleTwitterCallback'])->name('auth.twitter.callback');

Route::get('/enter-email', [TestController::class, 'showEnterEmailForm'])->name('enter.email');
Route::post('/enter-email', [TestController::class, 'handleEnterEmailForm'])->name('handle.email');

// Authentication Routes
Auth::routes();
