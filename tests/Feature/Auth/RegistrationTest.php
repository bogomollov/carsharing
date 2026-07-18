<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'last_name' => 'Ivanov',
            'first_name' => 'Ivan',
            'middle_name' => 'Ivanovich',
            'passport_series' => '12 34',
            'passport_number' => '567890',
            'driverlicense_series' => '12 34',
            'driverlicense_number' => '567890',
            'driverlicense_date' => '01.01.2020',
            'phone' => '79000000000',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
