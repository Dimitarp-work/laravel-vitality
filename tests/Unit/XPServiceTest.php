<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\XPLog;
use App\Services\XPService;

class XPServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_reward_adds_xp_and_credits_and_logs()
    {
        $user = User::factory()->create(['xp' => 0, 'credits' => 0]);
       $service = app(XPService::class);

        $service->reward($user, 100, 250, 'Weekly Bonus');

        $user->refresh();

        $this->assertEquals(100, $user->xp);
        $this->assertEquals(250, $user->credits);

        $this->assertDatabaseHas('xp_logs', [
            'user_id' => $user->id,
            'xp_change' => 100,
            'credit_change' => 250,
            'reason' => 'Weekly Bonus',
        ]);
    }

    public function test_deduct_credits_decreases_balance_and_logs()
    {
        $user = User::factory()->create(['credits' => 500]);
       $service = app(XPService::class);

        $service->deductCredits($user, 150, 'Purchased Badge');

        $user->refresh();

        $this->assertEquals(350, $user->credits);

        $this->assertDatabaseHas('xp_logs', [
            'user_id' => $user->id,
            'xp_change' => 0,
            'credit_change' => -150,
            'reason' => 'Purchased Badge',
        ]);
    }

    public function test_reward_only_credits()
{
    $user = User::factory()->create(['xp' => 0, 'credits' => 0]);
    $service = app(XPService::class);

    $service->reward($user, 0, 100, 'Daily login');

    $user->refresh();

    $this->assertEquals(0, $user->xp);
    $this->assertEquals(100, $user->credits);

    $this->assertDatabaseHas('xp_logs', [
        'user_id' => $user->id,
        'xp_change' => 0,
        'credit_change' => 100,
        'reason' => 'Daily login',
    ]);
}
}
