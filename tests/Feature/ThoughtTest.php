<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\XPLog;

class ThoughtTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_thought_gives_xp_and_credits()
    {
        $user = User::factory()->create(['xp' => 0, 'credits' => 0]);

        $response = $this->actingAs($user)->post('/thought', [
            'thought' => 'This is a test thought.'
        ]);

        $response->assertRedirect(); 

        $user->refresh();

        $this->assertEquals(50, $user->xp);
        $this->assertEquals(50, $user->credits);

        $this->assertDatabaseHas('xp_logs', [
            'user_id' => $user->id,
            'xp_change' => 50,
            'credit_change' => 50
        ]);
    }
}
