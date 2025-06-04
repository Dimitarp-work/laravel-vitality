<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DailyCheckInController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\ThoughtController;
use App\Http\Middleware\AdminMiddleware;

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
Route::get('/trigger-500', function () {
    abort(500);
});
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

Route::resource('articles', ArticleController::class)->only(['index', 'show']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

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

Route::get('/challenges',  [Controller::class, 'challenges'])->name('challenges');
Route::get('/goals',  [GoalController::class, 'goals'])->name('goals');
Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
Route::post('/goals/default/{goal}/start', [GoalController::class, 'startDefault'])->name('goals.start-default');
Route::put('/goals/{goal}', [GoalController::class, 'update'])->name('goals.update');
Route::delete('/goals/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
Route::post('/goals/{goal}/daily-update', [GoalController::class, 'dailyUpdate'])->name('goals.daily-update');


