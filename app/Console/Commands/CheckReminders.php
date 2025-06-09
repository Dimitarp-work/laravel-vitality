<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckReminders extends Command
{
    protected $signature = 'reminders:check';
    protected $description = 'Check and send reminders based on user settings';

    public function handle()
    {
        $users = User::with(['reminders.relatedEntity', 'notificationSettings'])
            ->whereHas('reminders', function ($query) {
                $query->where('is_completed', false);
            })
            ->get();

        foreach ($users as $user) {
            $settings = $user->notificationSettings;

            if (!$settings || !$settings->is_enabled) {
                continue;
            }

            $lastNotification = $settings->last_notification_at;
            $now = Carbon::now();

            if (!$lastNotification || $now->diffInMinutes($lastNotification) >= $settings->reminder_interval) {
                $notifications = [];

                foreach ($user->reminders as $reminder) {
                    if ($reminder->is_completed) {
                        continue;
                    }

                    $notification = [
                        'icon' => 'notifications',
                        'title' => 'Reminder',
                        'message' => 'Time to check your reminder!'
                    ];

                    switch ($reminder->type) {
                        case 'goal':
                            $goal = $reminder->relatedEntity;
                            if ($goal) {
                                $notification['icon'] = 'flag';
                                $notification['title'] = 'Goal Reminder';
                                $notification['message'] = $goal->title;
                                $notification['progress'] = $goal->progress;
                            }
                            break;
                        case 'challenge':
                            $challenge = $reminder->relatedEntity;
                            if ($challenge) {
                                $notification['icon'] = 'emoji_events';
                                $notification['title'] = 'Challenge Reminder';
                                $notification['message'] = $challenge->title;
                            }
                            break;
                        case 'daily_checkin':
                            $checkin = $reminder->relatedEntity;
                            if ($checkin) {
                                $notification['icon'] = 'check_circle';
                                $notification['title'] = 'Daily Check-in Reminder';
                                $notification['message'] = $checkin->title;
                            }
                            break;
                    }

                    $notifications[] = $notification;
                }

                if (!empty($notifications)) {
                    // Store notifications in session for the next request
                    $existingNotifications = session('notifications', []);
                    array_unshift($existingNotifications, ...$notifications);
                    $existingNotifications = array_slice($existingNotifications, 0, 10);

                    session()->put('notifications', $existingNotifications);
                    session()->put('toast_notification', $notifications[0]); // Show first notification as toast

                    // Update last notification time
                    $settings->update(['last_notification_at' => $now]);
                }
            }
        }
    }
}
