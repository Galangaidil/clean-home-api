<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'name' => 'Apriani',
            'email' => 'apriani.kitana@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    public function test_user_can_register_using_api()
    {
        $response = $this->postJson(route('v1.register'), $this->data);

        $response->assertCreated();
    }

    public function test_user_can_not_register_if_the_email_address_has_been_taken()
    {
        User::factory()->create(['email' => $this->data['email']]);

        $response = $this->postJson(route('v1.register'), $this->data);

        $response->assertUnprocessable();
    }

    public function test_password_confirmation_should_be_same()
    {
        $this->data['password_confirmation'] = 'it is different from password';

        $response = $this->postJson(route('v1.register'), $this->data);

        $response->assertUnprocessable();
    }


}
