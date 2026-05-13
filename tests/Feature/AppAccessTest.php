<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_root(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_is_redirected_to_dashboard_from_root(): void
    {
        $user = $this->makeUser(User::ROLE_STAFF);

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(route('dashboard'));
    }

    public function test_authenticated_user_can_open_profile_page(): void
    {
        $user = $this->makeUser(User::ROLE_RECEPTIONIST);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
    }

    private function makeUser(string $role, array $attributes = []): User
    {
        static $counter = 1;

        $user = User::create(array_merge([
            'name' => ucfirst($role).' User '.$counter,
            'email' => $role.$counter.'@example.com',
            'password' => 'password123',
            'role' => $role,
        ], $attributes));

        $counter++;

        return $user;
    }
}
