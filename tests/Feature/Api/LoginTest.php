<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_authenticated_using_api()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('v1.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertJson(['message' => 'Login berhasil.']);
    }
}
