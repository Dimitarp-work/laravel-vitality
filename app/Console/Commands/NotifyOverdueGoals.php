<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Goal;
use App\Notifications\GoalOverdueNotification;

class NotifyOverdueGoals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-overdue-goals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify employees about overdue goals with recommendations';

    /**
     * Execute the console command.
     */
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
                // Notify the user about their overdue goal
                $user->notify(new GoalOverdueNotification($goal));

                // Mark this goal as notified so it won't notify again
                $goal->notified_about_deadline = true;
                $goal->save();

                $this->info("Notified user {$user->id} for goal {$goal->id}");
            }
        }

        $this->info('Overdue goal notifications sent.');
    }
}
