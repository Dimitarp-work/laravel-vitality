<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use App\Models\Goal;
use App\Models\Challenge;
use App\Models\DailyCheckIn;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $settings = $user->notificationSettings ?? new NotificationSetting([
            'reminder_interval' => 60,
            'is_enabled' => true
        ]);

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'reminder_interval' => 'required|integer|min:15|max:1440', // Between 15 minutes and 24 hours
            'is_enabled' => 'boolean'
        ]);

        $user = auth()->user();
        $settings = $user->notificationSettings;

        if (!$settings) {
            $settings = new NotificationSetting();
            $settings->user_id = $user->id;
        }

        $settings->fill([
            'reminder_interval' => $request->reminder_interval,
            'is_enabled' => $request->boolean('is_enabled')
        ]);

        $settings->save();

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function testReminders()
    {
        $user = auth()->user();
        $reminders = $user->reminders()->where('is_completed', false)->get();

        if ($reminders->isEmpty()) {
            return redirect()->route('settings.index')
                ->with('toast_notification', [
                    'icon' => 'info',
                    'title' => 'No Reminders',
                    'message' => 'You don\'t have any active reminders to test with.'
                ])
                ->with('notifications', [[
                    'icon' => 'info',
                    'title' => 'No Reminders',
                    'message' => 'You don\'t have any active reminders to test with.'
                ]]);
        }

        // Get a random reminder
        $reminder = $reminders->random();

        // Create a notification based on the reminder type
        $notification = [
            'icon' => 'notifications',
            'title' => 'Test Reminder',
            'message' => 'This is a test notification'
        ];

        switch ($reminder->type) {
            case 'goal':
                $goal = Goal::find($reminder->entity_id);
                if ($goal) {
                    $notification['icon'] = 'flag';
                    $notification['title'] = 'Goal Reminder';
                    $notification['message'] = $goal->title;
                    $notification['progress'] = $goal->progress;
                }
                break;
            case 'challenge':
                $challenge = Challenge::find($reminder->entity_id);
                if ($challenge) {
                    $notification['icon'] = 'emoji_events';
                    $notification['title'] = 'Challenge Reminder';
                    $notification['message'] = $challenge->title;
                }
                break;
            case 'daily_checkin':
                $checkin = DailyCheckIn::find($reminder->entity_id);
                if ($checkin) {
                    $notification['icon'] = 'check_circle';
                    $notification['title'] = 'Daily Check-in Reminder';
                    $notification['message'] = $checkin->title;
                }
                break;
        }

        // Get existing notifications from session or initialize empty array
        $existingNotifications = session('notifications', []);

        // Add new notification to the beginning of the array
        array_unshift($existingNotifications, $notification);

        // Keep only the last 10 notifications
        $existingNotifications = array_slice($existingNotifications, 0, 10);

        return redirect()->route('settings.index')
            ->with('toast_notification', $notification)
            ->with('notifications', $existingNotifications);
    }
}
