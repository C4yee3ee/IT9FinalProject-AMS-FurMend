<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\ServiceRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_appointment_creation_requires_a_staff_member_assignment(): void
    {
        $admin = $this->makeUser(User::ROLE_ADMIN);
        $receptionist = $this->makeUser(User::ROLE_RECEPTIONIST);
        $client = $this->makeClient();

        $response = $this->actingAs($admin)->post(route('appointments.store'), [
            'client_id' => $client->id,
            'staff_id' => $receptionist->id,
            'service_type' => 'Initial Consultation',
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:00',
            'status' => Appointment::STATUS_SCHEDULED,
            'notes' => 'Testing invalid staff assignment.',
        ]);

        $response->assertSessionHasErrors('staff_id');
        $this->assertDatabaseCount('appointments', 0);
    }

    public function test_service_record_requires_a_completed_appointment(): void
    {
        $staff = $this->makeUser(User::ROLE_STAFF);
        $receptionist = $this->makeUser(User::ROLE_RECEPTIONIST);
        $client = $this->makeClient();
        $appointment = $this->makeAppointment($client, $staff, $receptionist, [
            'status' => Appointment::STATUS_CONFIRMED,
        ]);

        $response = $this->actingAs($staff)->post(route('service-records.store'), [
            'appointment_id' => $appointment->id,
            'description' => 'Attempted to create a premature record.',
            'service_date' => now()->toDateString(),
            'remarks' => 'Should not be saved.',
        ]);

        $response->assertSessionHasErrors('appointment_id');
        $this->assertDatabaseCount('service_records', 0);
    }

    public function test_client_with_history_cannot_be_deleted(): void
    {
        $receptionist = $this->makeUser(User::ROLE_RECEPTIONIST);
        $staff = $this->makeUser(User::ROLE_STAFF);
        $client = $this->makeClient();

        $appointment = $this->makeAppointment($client, $staff, $receptionist);

        ServiceRecord::create([
            'appointment_id' => $appointment->id,
            'client_id' => $client->id,
            'staff_id' => $staff->id,
            'description' => 'Completed check-up.',
            'service_date' => now()->toDateString(),
            'remarks' => 'Follow-up next week.',
        ]);

        $response = $this->actingAs($receptionist)->delete(route('clients.destroy', $client));

        $response->assertSessionHasErrors('client');
        $this->assertDatabaseHas('clients', ['id' => $client->id]);
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

    private function makeClient(): Client
    {
        static $counter = 1;

        $client = Client::create([
            'first_name' => 'Client',
            'last_name' => 'Example '.$counter,
            'email' => 'client'.$counter.'@example.com',
            'phone' => '09171234567',
            'address' => 'Quezon City',
            'notes' => 'Created from business rule tests.',
        ]);

        $counter++;

        return $client;
    }

    private function makeAppointment(Client $client, User $staff, User $creator, array $attributes = []): Appointment
    {
        return Appointment::create(array_merge([
            'client_id' => $client->id,
            'staff_id' => $staff->id,
            'service_type' => 'Consultation',
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '11:00',
            'status' => Appointment::STATUS_SCHEDULED,
            'notes' => 'Created from business rule tests.',
            'created_by' => $creator->id,
        ], $attributes));
    }
}
