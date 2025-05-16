<?php

use App\Http\Controllers\DailyCheckInController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\DashboardController;


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
    return view('home');
})->name('home');

Route::get('/settings',  [Controller::class, 'settings'])->name('settings');
Route::get('leaderboard',  [Controller::class, 'leaderboard'])->name('leaderboard');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/diary', function () {
    return view('diary');
})->name('diary');
Route::get('/challenges',  [Controller::class, 'challenges'])->name('challenges');
//Route::get('/checkins', [DailyCheckInController::class,'checkins'])->name('checkins');
Route::resource('/checkins', DailyCheckInController::class);
// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
