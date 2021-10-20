<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /** @test */
    public function user_can_log_out()
    {
        /** @var User */
        $user = User::factory()->create();
        $accessToken = $user->createToken('Login Access')->plainTextToken;

        $this->postJson(
            '/api/auth/logout',
            [],
            ['Authorization' => 'Bearer '.$accessToken]
        )
            ->assertNoContent();

        $this->assertEmpty($user->tokens);
    }
}
