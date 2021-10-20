<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function user_can_log_in()
    {
        $user = User::factory()->create();

        $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
        ->assertCreated();

        $this->assertNotEmpty($user->tokens);
    }

    /** @test */
    public function user_cant_login_with_wrong_password()
    {
        $user = User::factory()->create();

        $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'very-much-wrongg',
        ])
        ->assertJsonValidationErrors('email');

        $this->assertEmpty($user->tokens);
    }
}
