<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    private User $user;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_authenticated_using_api()
    {
        $response = $this->postJson(route('v1.login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertJson(['message' => 'Login berhasil.']);
    }

    public function test_user_can_not_authenticated_with_invalid_password()
    {
        $response = $this->postJson(route('v1.login'), [
            'email' => $this->user->email,
            'password' => 'wrong password'
        ]);

        $response->assertUnprocessable();
    }


}
