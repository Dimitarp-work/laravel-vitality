<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DailyCheckInController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\ThoughtController;
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

Route::get('/settings', function () {
    return view('under-construction');
})->name('settings');

Route::get('/my-goals', function () {
    return view('under-construction');
})->name('my-goals');

Route::get('/store', function () {
    return view('under-construction');
})->name('store');

Route::get('/appearance', function () {
    return view('under-construction');
})->name('appearance');

Route::get('/leaderboard', function () {
    return view('under-construction');
})->name('leaderboard');

Route::get('/diary', function () {
    return view('under-construction');
})->name('diary');

Route::resource('/articles', ArticleController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::get('/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::post('/challenges/{challenge}/join', [ChallengeController::class, 'join'])->name('challenges.join');
    Route::post('/challenges/{challenge}/log', [ChallengeController::class, 'logProgress'])->name('challenges.log');
    Route::get('/challenges/{challenge}/edit', [ChallengeController::class, 'edit'])->name('challenges.edit');
    Route::put('/challenges/{challenge}', [ChallengeController::class, 'update'])->name('challenges.update');
    Route::get('/challenges/{challenge}/confirm-delete', [ChallengeController::class, 'confirmDelete'])->name('challenges.confirmDelete');
    Route::delete('/challenges/{challenge}', [ChallengeController::class, 'destroy'])->name('challenges.destroy');
});


//Route::get('/checkins', [DailyCheckInController::class,'checkins'])->name('checkins');

// Check-in routes
Route::middleware('auth')->group(function () {
    Route::get('/checkins/reminders', [DailyCheckInController::class, 'reminders'])->name('checkins.reminders');
    Route::post('/checkins/{dailyCheckIn}/complete', [DailyCheckInController::class, 'complete'])->name('checkins.complete');
    Route::get('/checkins/week', [DailyCheckInController::class, 'week'])->name('checkins.week');
    Route::resource('/checkins', DailyCheckInController::class);
});
// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Mood routes
Route::middleware(['auth'])->post('/mood', [MoodController::class, 'store'])->name('mood.store');
Route::middleware(['auth'])->get('/mood/week', [MoodController::class, 'week'])->name('mood.week');

Route::get('/dashboard', function () {return view('dashboard'); })->name('dashboard');

Route::post('/thought', [ThoughtController::class, 'store'])->name('thought.store');
require __DIR__.'/auth.php';
