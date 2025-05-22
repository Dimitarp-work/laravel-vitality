<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\XPLog;
use App\Services\XPService;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_xp_increases_xp_and_logs()
    {
        $user = User::factory()->create(['xp' => 0]);
        $user->addXP(100, 'Test Reason');

        $this->assertEquals(100, $user->fresh()->xp);
        $this->assertDatabaseHas('xp_logs', [
            'user_id' => $user->id,
            'xp_change' => 100,
            'credit_change' => 0,
            'reason' => 'Test Reason'
        ]);
    }

    public function test_add_credits_increases_credits_and_logs()
    {
        $user = User::factory()->create(['credits' => 0]);
        $user->addCredits(200, 'Test Credits');

        $this->assertEquals(200, $user->fresh()->credits);
        $this->assertDatabaseHas('xp_logs', [
            'user_id' => $user->id,
            'xp_change' => 0,
            'credit_change' => 200,
            'reason' => 'Test Credits'
        ]);
    }
}

class XPServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_add_xp()
    {
        $user = User::factory()->create(['xp' => 0]);
        $service = new XPService();
        $service->addXP($user, 75, 'XP via Service');

        $this->assertEquals(75, $user->fresh()->xp);
        $this->assertDatabaseHas('xp_logs', [
            'xp_change' => 75,
            'credit_change' => 0,
            'reason' => 'XP via Service'
        ]);
    }

    public function test_service_add_credits()
    {
        $user = User::factory()->create(['credits' => 0]);
        $service = new XPService();
        $service->addCredits($user, 120, 'Credits via Service');

        $this->assertEquals(120, $user->fresh()->credits);
        $this->assertDatabaseHas('xp_logs', [
            'xp_change' => 0,
            'credit_change' => 120,
            'reason' => 'Credits via Service'
        ]);
    }

    public function test_service_deduct_credits()
    {
        $user = User::factory()->create(['credits' => 300]);
        $service = new XPService();
        $service->deductCredits($user, 100, 'Used Credits');

        $this->assertEquals(200, $user->fresh()->credits);
        $this->assertDatabaseHas('xp_logs', [
            'credit_change' => -100,
            'reason' => 'Used Credits'
        ]);
    }
}
