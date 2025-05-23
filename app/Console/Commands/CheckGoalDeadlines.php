<?php

namespace App\Console\Commands;

use App\Models\Goal;
use App\Notifications\GoalOverdueNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckGoalDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-goal-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue goals and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting overdue goals check...');

        try {
            $overdueGoals = Goal::with('user')
                ->where('achieved', false)
                ->whereNotNull('deadline')
                ->where('deadline', '<', now())
                ->where('notified_about_deadline', false)
                ->get();

            $count = 0;

            foreach ($overdueGoals as $goal) {
                try {
                    $this->info("Notifying user {$goal->user->id} about goal {$goal->id}");

                    $goal->user->notify(new GoalOverdueNotification($goal));
                    $goal->update(['notified_about_deadline' => true]);

                    $count++;
                } catch (\Exception $e) {
                    Log::error("Failed to notify user {$goal->user->id} about goal {$goal->id}: " . $e->getMessage());
                    $this->error("Error notifying user {$goal->user->id}: " . $e->getMessage());
                }
            }

            $this->info("Completed. Notified about {$count} overdue goals.");
            Log::info("Goal deadline check completed. Notified about {$count} overdue goals.");

            return 0;
        } catch (\Exception $e) {
            Log::error("Goal deadline check failed: " . $e->getMessage());
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
}
