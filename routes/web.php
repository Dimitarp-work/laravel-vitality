<?php

use App\Http\Controllers\GoalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ArticleController;


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
});

Route::get('/settings',  [Controller::class, 'settings'])->name('settings');
Route::get('leaderboard',  [Controller::class, 'leaderboard'])->name('leaderboard');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/diary', function () {
    return view('diary');
})->name('diary');
Route::get('/challenges',  [Controller::class, 'challenges'])->name('challenges');
Route::get('/goals',  [GoalController::class, 'goals'])->name('goals');
Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
Route::post('/goals/default/{goal}/start', [GoalController::class, 'startDefault'])->name('goals.start-default');
Route::put('/goals/{goal}', [GoalController::class, 'update'])->name('goals.update');
Route::delete('/goals/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
