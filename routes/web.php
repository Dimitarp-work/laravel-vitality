<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ChallengeController,
    DailyCheckInController,
    GoalController,
    LeaderboardController,
    ArticleController,
    ProfileController,
    MoodController,
    ThoughtController,
    CapyChatController,
    RemindersController,
    SettingsController,
    DiaryController,
    BadgeController,
    Controller
};
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Goal;
use App\Notifications\GoalOverdueNotification;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AppearanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/home', [Controller::class, 'home'])->middleware(['auth', 'verified'])->name('home');

Route::redirect('/', '/login');

Route::get('/trigger-500', fn () => abort(500));

Route::get('/login', fn () => view('welcome'));

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::post('/shop/badge/{badgeId}/toggle', [ShopController::class, 'setBadge'])->name('badges.toggle');
Route::post('/shop/badge/remove', [ShopController::class, 'removeBadge'])->name('badges.remove');
Route::post('/store/purchase/{item}', [ShopController::class, 'purchase'])->name('store.purchase');
Route::post('/store/activate/{type}/{id}', [ShopController::class, 'activate'])->name('customize.activate');

    // Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/test-reminders', [SettingsController::class, 'testReminders'])->name('settings.test-reminders');
    Route::post('/settings/set-test-reminder-interval', [SettingsController::class, 'setTestReminderInterval'])->name('settings.set-test-reminder-interval');
    Route::post('/notifications/clear', [SettingsController::class, 'clearNotifications'])->name('notifications.clear');

    // Diary routes
    Route::get('/diary', [DiaryController::class, 'index'])->name('diary');
    Route::post('/diary', [DiaryController::class, 'store'])->name('diary.store');
    Route::get('/diary/past', [DiaryController::class, 'past'])->name('diary.past');

    // Check-ins routes
    Route::resource('/checkins', DailyCheckInController::class)->parameters([
        'checkins' => 'dailyCheckIn'
    ]);
    Route::post('/checkins/{dailyCheckIn}/complete', [DailyCheckInController::class, 'complete'])->name('checkins.complete');
    Route::get('/checkins/week', [DailyCheckInController::class, 'week'])->name('checkins.week');

    // Reminders routes
    Route::get('/reminders', [RemindersController::class, 'index'])->name('reminders.index');
    Route::get('/reminders/create', [RemindersController::class, 'create'])->name('reminders.create');
    Route::post('/reminders', [RemindersController::class, 'store'])->name('reminders.store');
    Route::delete('/reminders/{reminder}', [RemindersController::class, 'destroy'])->name('reminders.destroy');

    // Mood routes
    Route::post('/mood', [MoodController::class, 'store'])->name('mood.store');
    Route::get('/mood/week', [MoodController::class, 'week'])->name('mood.week');

    // Goals routes
    Route::get('/goals', [GoalController::class, 'goals'])->name('goals');
    Route::get('/goals/create', [GoalController::class, 'create'])->name('goals.create');
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');
    Route::get('/goals/{goal}/edit', [GoalController::class, 'edit'])->name('goals.edit');
    Route::post('/goals/default/{goal}/start', [GoalController::class, 'startDefault'])->name('goals.start-default');
    Route::put('/goals/{goal}', [GoalController::class, 'update'])->name('goals.update');
    Route::delete('/goals/{goal}', [GoalController::class, 'destroy'])->name('goals.destroy');
    Route::post('/goals/{goal}/daily-update', [GoalController::class, 'dailyUpdate'])->name('goals.daily-update');

    // Thought route
    Route::post('/thought', [ThoughtController::class, 'store'])->name('thought.store');

    // Badges
    Route::post('/badges', [BadgeController::class, 'store']);

    // CapyChat
    Route::get('/capychat/unread-count', [CapyChatController::class, 'unreadCount'])->name('capychat.unreadCount');
    Route::post('/capychat/mark-read', [CapyChatController::class, 'markRead'])->name('capychat.markRead');

    // Leaderboard routes
    Route::get('/leaderboard/xp', [LeaderboardController::class, 'xp'])->name('leaderboard.xp');
    Route::get('/leaderboard/badges', [LeaderboardController::class, 'badges'])->name('leaderboard.badges');

    // Challenges
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::get('/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::post('/challenges/{challenge}/join', [ChallengeController::class, 'join'])->name('challenges.join');
    Route::get('/challenges/{challenge}/participants', [ChallengeController::class, 'participants']);
    Route::post('/challenges/{challenge}/log', [ChallengeController::class, 'logProgress'])->name('challenges.log');
    Route::get('/challenges/{challenge}/edit', [ChallengeController::class, 'edit'])->name('challenges.edit');
    Route::put('/challenges/{challenge}', [ChallengeController::class, 'update'])->name('challenges.update');
    Route::get('/challenges/{challenge}/confirm-delete', [ChallengeController::class, 'confirmDelete'])->name('challenges.confirmDelete');
    Route::delete('/challenges/{challenge}', [ChallengeController::class, 'destroy'])->name('challenges.destroy');
    Route::delete('/challengesAdmin/{challenge}', [ChallengeController::class, 'destroyAdmin'])->name('challenges.destroyAdmin');
});
Route::middleware(['auth'])->post('/badges', [BadgeController::class, 'store']);

// Public CapyChat routes
Route::get('/capychat', [CapyChatController::class, 'index'])->name('capychat');
Route::post('/capychat/message', [CapyChatController::class, 'message'])->name('capychat.message');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/articles/manage', [ArticleController::class, 'manageArticles'])->name('admin.articles.index');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity_logs.index');
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
    Route::get('/challenges/manage', [ChallengeController::class, 'manageChallenges'])->name('admin.challenges.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/appearance', [AppearanceController::class, 'index'])->name('appearance.index');
    Route::post('/appearance', [AppearanceController::class, 'update'])->name('appearance.update');
    Route::post('/appearance/reset', [\App\Http\Controllers\AppearanceController::class, 'reset'])->name('appearance.reset');

});
Route::post('/store/purchase/{id}', [ShopController::class, 'purchase'])->name('store.purchase');
Route::post('/customize/activate/{type}/{id}', [ShopController::class, 'activate'])->name('customize.activate');


// Public article routes
Route::resource('articles', ArticleController::class)->only(['index', 'show']);

// Under construction pages


// Manual test route
Route::get('/test-notify-overdue', function () {
    $overdueGoals = Goal::where('notified_about_deadline', false)
        ->where('achieved', false)
        ->whereNotNull('deadline')
        ->where('deadline', '<', now())
        ->get();

    $output = '';
    foreach ($overdueGoals as $goal) {
        $user = $goal->user;
        if ($user) {
            $user->notify(new GoalOverdueNotification($goal));
            $goal->notified_about_deadline = true;
            $goal->save();
            $output .= "Notified user {$user->id} for goal {$goal->id}<br>";
        }
    }

    return $output ?: 'No overdue goals to notify.';
});

// Auth routes
require __DIR__.'/auth.php';


