<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use App\Models\Goal;
use App\Models\Challenge;
use App\Models\DailyCheckIn;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $settings = $user->notificationSettings;

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'reminder_interval' => 'required|integer|min:15|max:1440', // Between 15 minutes and 24 hours
            'is_enabled' => 'boolean', // Re-add this validation
        ]);

        $userId = Auth::id();

        $notificationSettings = NotificationSetting::where('user_id', $userId)->first();

        // Ensure $notificationSettings exists before attempting to update
        // This fallback should rarely be hit if user registration and index methods are correct
        if (!$notificationSettings) {
            $notificationSettings = NotificationSetting::create([
                'user_id' => $userId,
                'reminder_interval' => 60, // Default
                'is_enabled' => true, // Default
            ]);
        }

        $notificationSettings->update([
            'reminder_interval' => $validated['reminder_interval'],
            'is_enabled' => $request->boolean('is_enabled'), // Use boolean() helper
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function testReminders()
    {
        $user = auth()->user();
        $reminders = $user->reminders()->where('is_completed', false)->get();

        if ($reminders->isEmpty()) {
            return redirect()->route('settings.index')
                ->with('success', 'You don\'t have any active reminders to test with.');
        }

        // Get a random reminder
        $reminder = $reminders->random();

        // Prepare notification data for session
        $notificationData = [
            'icon' => 'notifications',
            'title' => 'Test Reminder',
            'message' => 'This is a test notification'
        ];

        switch ($reminder->type) {
            case 'goal':
                $goal = Goal::find($reminder->entity_id);
                if ($goal) {
                    $notificationData['icon'] = 'flag';
                    $notificationData['title'] = 'Goal Reminder';
                    $notificationData['message'] = $goal->title;
                    $notificationData['progress'] = $goal->progress;
                }
                break;
            case 'challenge':
                $challenge = Challenge::find($reminder->entity_id);
                if ($challenge) {
                    $notificationData['icon'] = 'emoji_events';
                    $notificationData['title'] = 'Challenge Reminder';
                    $notificationData['message'] = $challenge->title;
                }
                break;
            case 'daily_checkin':
                $checkin = DailyCheckIn::find($reminder->entity_id);
                if ($checkin) {
                    $notificationData['icon'] = 'check_circle';
                    $notificationData['title'] = 'Daily Check-in Reminder';
                    $notificationData['message'] = $checkin->title;
                }
                break;
        }

        // Store the test notification in session
        $existingNotifications = session('notifications', []);
        array_unshift($existingNotifications, $notificationData);
        $existingNotifications = array_slice($existingNotifications, 0, 10); // Keep only the last 10
        session()->put('notifications', $existingNotifications);

        // Store the latest notification for toast display
        session()->flash('toast_notification', $notificationData);

        return redirect()->route('settings.index')
            ->with('success', 'Test notification sent!');
    }

    public function setTestReminderInterval()
    {
        $user = auth()->user();
        $settings = $user->notificationSettings;
        $now = Carbon::now();

        if (!$settings) {
            $settings = NotificationSetting::create([
                'user_id' => $user->id,
                'reminder_interval' => 1, // Set to 1 minute for rapid testing
                'is_enabled' => true,
                'last_notification_at' => $now->subMinute(), // Set to 1 minute ago to force immediate check
            ]);
        } else {
            $settings->update([
                'reminder_interval' => 1, // Set to 1 minute for rapid testing
                'last_notification_at' => $now->subMinute(), // Set to 1 minute ago to force immediate check
            ]);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Reminder interval set to 1 minute, and ready for immediate testing!');
    }

    public function clearNotifications()
    {
        session()->forget('notifications');
        return back();
    }
}
