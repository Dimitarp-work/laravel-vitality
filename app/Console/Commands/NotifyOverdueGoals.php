<?php

use App\Models\Goal;
use App\Models\OverdueGoalNotification; // New model for in-app notifications
use Illuminate\Console\Command;

class NotifyOverdueGoals extends Command
{
    protected $signature = 'app:notify-overdue-goals';
    protected $description = 'Notify users in-app about overdue goals with recommendations';

    public function handle()
    {
        $overdueGoals = Goal::where('notified_about_deadline', false)
            ->where('achieved', false)
            ->whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->get();

        foreach ($overdueGoals as $goal) {
            $user = $goal->user;

            if ($user) {
                // Save the notification in the database instead of sending email
                \App\Models\OverdueGoalNotification::create([
                    'user_id' => $user->id,
                    'goal_id' => $goal->id,
                    'message' => 'Your goal "' . $goal->title . '" is overdue. Consider updating your progress or adjusting the deadline.',
                ]);

                $goal->notified_about_deadline = true;
                $goal->save();

                $this->info("Saved in-app notification for user {$user->id} for goal {$goal->id}");
            }
        }

        $this->info('In-app overdue notifications saved.');
    }
}
