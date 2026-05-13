<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_receptionist_cannot_access_admin_user_management(): void
    {
        $receptionist = $this->makeUser(User::ROLE_RECEPTIONIST);

        $response = $this->actingAs($receptionist)->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_user_management(): void
    {
        $admin = $this->makeUser(User::ROLE_ADMIN);

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertOk();
    }

    public function test_staff_only_sees_their_assigned_appointments(): void
    {
        $staffA = $this->makeUser(User::ROLE_STAFF, ['name' => 'Alpha Staff', 'email' => 'alpha.staff@example.com']);
        $staffB = $this->makeUser(User::ROLE_STAFF, ['name' => 'Beta Staff', 'email' => 'beta.staff@example.com']);
        $receptionist = $this->makeUser(User::ROLE_RECEPTIONIST);
        $clientOne = $this->makeClient('Anna', 'Lopez', 'anna.lopez@example.com');
        $clientTwo = $this->makeClient('Mark', 'Santos', 'mark.santos@example.com');

        $assignedAppointment = $this->makeAppointment($clientOne, $staffA, $receptionist, [
            'service_type' => 'Assigned Visit',
        ]);

        $otherAppointment = $this->makeAppointment($clientTwo, $staffB, $receptionist, [
            'service_type' => 'Other Visit',
        ]);

        $indexResponse = $this->actingAs($staffA)->get(route('appointments.index'));

        $indexResponse->assertOk();
        $indexResponse->assertSee('Assigned Visit');
        $indexResponse->assertDontSee('Other Visit');

        $showResponse = $this->actingAs($staffA)->get(route('appointments.show', $otherAppointment));

        $showResponse->assertForbidden();

        $ownShowResponse = $this->actingAs($staffA)->get(route('appointments.show', $assignedAppointment));

        $ownShowResponse->assertOk();
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

    private function makeClient(string $firstName, string $lastName, string $email): Client
    {
        return Client::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => '09171234567',
            'address' => 'Manila',
        ]);
    }

    private function makeAppointment(Client $client, User $staff, User $creator, array $attributes = []): Appointment
    {
        return Appointment::create(array_merge([
            'client_id' => $client->id,
            'staff_id' => $staff->id,
            'service_type' => 'Consultation',
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '09:00',
            'status' => Appointment::STATUS_SCHEDULED,
            'notes' => 'Scheduled from test.',
            'created_by' => $creator->id,
        ], $attributes));
    }
}
