<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function registerScreen(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    #[Test]
    public function register(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => fake()->freeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionDoesntHaveErrors();

        $this->assertAuthenticated();

        $response->assertRedirect(route('home'));
    }
}
