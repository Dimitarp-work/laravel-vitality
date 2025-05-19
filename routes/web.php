<?php

use App\Http\Controllers\ChallengesController;
use App\Http\Controllers\DailyCheckInController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
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
Route::redirect('/', '/login');


Route::get('/login', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');

})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/settings',  [Controller::class, 'settings'])->name('settings');
Route::get('leaderboard',  [Controller::class, 'leaderboard'])->name('leaderboard');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/diary', function () {
    return view('diary');
})->name('diary');
Route::get('/challenges',  [ChallengesController::class, 'index'])->name('challenges.index');
Route::get('/challenges/create', [ChallengesController::class, 'create'])->name('challenges.create');
Route::post('/challenges', [ChallengesController::class, 'store'])->name('challenges.store');

//Route::get('/checkins', [DailyCheckInController::class,'checkins'])->name('checkins');

// Check-in routes
Route::get('/checkins/week', [DailyCheckInController::class, 'week'])->name('checkins.week');
Route::get('/checkins/reminders', [DailyCheckInController::class, 'reminders'])->name('checkins.reminders');
Route::resource('/checkins', DailyCheckInController::class);

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
