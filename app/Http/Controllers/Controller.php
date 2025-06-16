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

    function home(): View{
        return view('home');
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

            // Check if we have notification settings and if they are enabled
            if (!$settings || !$settings->is_enabled) {
                return;
            }

            // Check if the reminder interval has passed
            $lastNotification = $settings->last_notification_at;
            $now = Carbon::now();

            if ($lastNotification && $now->diffInMinutes($lastNotification) < $settings->reminder_interval) {
                return;
            }

            // Add a random chance (e.g., 1 in 5 requests)
            if (rand(1, 5) !== 1) {
                return;
            }

            // Get a random uncompleted reminder for the user
            $reminder = $user->reminders()->where('is_completed', false)->inRandomOrder()->first();

            if ($reminder) {
                // Manually load the related entity
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

                // Store notifications in session
                $existingNotifications = session('notifications', []);
                array_unshift($existingNotifications, $notificationData);
                $existingNotifications = array_slice($existingNotifications, 0, 10); // Keep only the last 10
                session()->put('notifications', $existingNotifications);

                // Store the latest notification for toast display
                session()->flash('toast_notification', $notificationData);

                // Update last notification time
                $settings->update(['last_notification_at' => $now]);
            }
        }
    }
}
