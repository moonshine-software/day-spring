<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class ProfileUpdateTest extends AuthTestCase
{
    use RefreshDatabase;

    #[Test]
    public function profileUpdate(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->post(route('profile.update'), [
                'name' => $user->name,
                'email' => fake()->freeEmail(),
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');
    }
}
