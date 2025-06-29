<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationSetting;
use App\Models\Reminder;
use App\Models\Goal;
use App\Models\Challenge;
use App\Models\DailyCheckIn;
use Carbon\Carbon;
use App\Models\Article;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->triggerInAppNotification();
            return $next($request);
        });
    }

    public function home(): View
    {
        $user = Auth::user();
        $topReminders = collect();
        if ($user) {
            $topReminders = $user->reminders()
                ->where('is_completed', false)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            // Eager load related entities manually
            foreach ($topReminders as $reminder) {
                switch ($reminder->type) {
                    case 'goal':
                        $reminder->relatedEntity = \App\Models\Goal::find($reminder->entity_id);
                        break;
                    case 'challenge':
                        $reminder->relatedEntity = \App\Models\Challenge::find($reminder->entity_id);
                        break;
                    case 'daily_checkin':
                        $reminder->relatedEntity = \App\Models\DailyCheckIn::find($reminder->entity_id);
                        break;
                }
            }
        }
        $newestArticle = \App\Models\Article::orderBy('created_at', 'desc')->first();
        $mostPopularArticle = \App\Models\Article::orderBy('views', 'desc')->first();
        // Avoid duplicate if both are the same
        if ($newestArticle && $mostPopularArticle && $newestArticle->id === $mostPopularArticle->id) {
            $mostPopularArticle = null;
        }
        return view('home', compact('topReminders', 'newestArticle', 'mostPopularArticle'));
    }

    function settings(): View{
        return view('settings');
    }

    function challenges(): View{
        return view('challenges.index');
    }

    protected function triggerInAppNotification()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $settings = $user->notificationSettings;

            if (!$settings || !$settings->is_enabled) {
                return;
            }

            $lastNotification = $settings->last_notification_at;
            $now = Carbon::now();

            if ($lastNotification && $now->diffInMinutes($lastNotification) < $settings->reminder_interval) {
                return;
            }

            if (rand(1, 5) !== 1) {
                return;
            }

            $reminder = $user->reminders()->where('is_completed', false)->inRandomOrder()->first();

            if ($reminder) {
                $relatedEntity = null;
                switch ($reminder->type) {
                    case 'goal':
                        $relatedEntity = Goal::find($reminder->entity_id);
                        break;
                    case 'challenge':
                        $relatedEntity = Challenge::find($reminder->entity_id);
                        break;
                    case 'daily_checkin':
                        $relatedEntity = DailyCheckIn::find($reminder->entity_id);
                        break;
                }

                $notificationData = [
                    'icon' => 'notifications',
                    'title' => 'Reminder',
                    'message' => 'Time to check your reminder!',
                    'progress' => null,
                ];

                if ($relatedEntity) {
                    switch ($reminder->type) {
                        case 'goal':
                            $notificationData['icon'] = 'flag';
                            $notificationData['title'] = 'Goal Reminder';
                            $notificationData['message'] = $relatedEntity->title;
                            $notificationData['progress'] = $relatedEntity->progress;
                            break;
                        case 'challenge':
                            $notificationData['icon'] = 'emoji_events';
                            $notificationData['title'] = 'Challenge Reminder';
                            $notificationData['message'] = $relatedEntity->title;
                            break;
                        case 'daily_checkin':
                            $notificationData['icon'] = 'check_circle';
                            $notificationData['title'] = 'Daily Check-in Reminder';
                            $notificationData['message'] = $relatedEntity->title;
                            break;
                    }
                }

                $existingNotifications = session('notifications', []);
                array_unshift($existingNotifications, $notificationData);
                $existingNotifications = array_slice($existingNotifications, 0, 10);
                session()->put('notifications', $existingNotifications);

                session()->flash('toast_notification', $notificationData);

                $settings->update(['last_notification_at' => $now]);
            }
        }
    }
}
