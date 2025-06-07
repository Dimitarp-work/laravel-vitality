<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Goal;
use App\Models\User;
use App\Models\OverdueGoalNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoalBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_notification_for_overdue_unachieved_goals()
    {
        $user = User::factory()->create();

        $goal = Goal::factory()->create([
            'user_id' => $user->id,
            'deadline' => now()->subDay(),
            'achieved' => false,
            'notified_about_deadline' => false,
        ]);

        $this->artisan('app:notify-overdue-goals');

        $this->assertDatabaseHas('overdue_goal_notifications', [
            'user_id' => $user->id,
            'goal_id' => $goal->id,
        ]);

        $this->assertDatabaseHas('goals', [
            'id' => $goal->id,
            'notified_about_deadline' => true,
        ]);
    }

    /** @test */
    public function it_does_not_create_notification_for_achieved_goals()
    {
        $user = User::factory()->create();

        $goal = Goal::factory()->create([
            'user_id' => $user->id,
            'deadline' => now()->subDay(),
            'achieved' => true,
            'notified_about_deadline' => false,
        ]);

        $this->artisan('app:notify-overdue-goals');

        $this->assertDatabaseMissing('overdue_goal_notifications', [
            'goal_id' => $goal->id,
        ]);
    }
}
