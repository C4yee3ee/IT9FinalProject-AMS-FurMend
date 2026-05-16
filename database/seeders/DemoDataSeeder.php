<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\ServiceRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Prevent duplicate demo data on re-runs
        if (Client::count() > 0) {
            return;
        }

        $staffMembers   = User::where('role', User::ROLE_STAFF)->get();
        $receptionists  = User::where('role', User::ROLE_RECEPTIONIST)->get();

        if ($staffMembers->isEmpty() || $receptionists->isEmpty()) {
            return;
        }

        // ─── Clients with Pet Info ───────────────────────────
        $clientsData = [
            ['first_name' => 'Anna',    'last_name' => 'Lopez',     'email' => 'anna.lopez@email.com',     'phone' => '09171234567', 'address' => '123 Rizal St, Quezon City',  'pet_name' => 'Mochi',    'pet_species' => 'Dog',    'pet_breed' => 'Shih Tzu',           'notes' => 'Morning appointments preferred.'],
            ['first_name' => 'Mark',    'last_name' => 'Santos',    'email' => 'mark.santos@email.com',    'phone' => '09179876543', 'address' => '45 Mabini Ave, Manila',      'pet_name' => 'Rocky',    'pet_species' => 'Dog',    'pet_breed' => 'German Shepherd',    'notes' => 'Allergic to certain medications.'],
            ['first_name' => 'Sofia',   'last_name' => 'Dela Cruz', 'email' => 'sofia.dc@email.com',       'phone' => '09181112233', 'address' => '78 Bonifacio Blvd, Makati',  'pet_name' => 'Whiskers', 'pet_species' => 'Cat',    'pet_breed' => 'Persian',            'notes' => 'Very anxious during visits.'],
            ['first_name' => 'Diego',   'last_name' => 'Reyes',     'email' => 'diego.reyes@email.com',    'phone' => '09194455667', 'address' => '200 Katipunan Rd, QC',       'pet_name' => 'Buddy',    'pet_species' => 'Dog',    'pet_breed' => 'Golden Retriever',   'notes' => 'Regular checkup client.'],
            ['first_name' => 'Elena',   'last_name' => 'Garcia',    'email' => 'elena.g@email.com',        'phone' => '09207788990', 'address' => '55 Ayala Ave, Makati',       'pet_name' => 'Luna',     'pet_species' => 'Cat',    'pet_breed' => 'Siamese',            'notes' => null],
            ['first_name' => 'Rico',    'last_name' => 'Bautista',  'email' => 'rico.b@email.com',         'phone' => '09211122334', 'address' => '15 Magsaysay St, Pasig',     'pet_name' => 'Max',      'pet_species' => 'Dog',    'pet_breed' => 'Labrador Retriever', 'notes' => 'Needs weight management advice.'],
            ['first_name' => 'Julia',   'last_name' => 'Mercado',   'email' => 'julia.m@email.com',        'phone' => '09223344556', 'address' => '88 Shaw Blvd, Mandaluyong', 'pet_name' => 'Cleo',     'pet_species' => 'Cat',    'pet_breed' => 'Maine Coon',         'notes' => 'Senior pet, handle with care.'],
            ['first_name' => 'Paolo',   'last_name' => 'Villanueva','email' => 'paolo.v@email.com',        'phone' => '09235566778', 'address' => '120 Ortigas Ave, Pasig',     'pet_name' => 'Brownie',  'pet_species' => 'Dog',    'pet_breed' => 'Beagle',             'notes' => 'First-time client.'],
            ['first_name' => 'Carmen',  'last_name' => 'Torres',    'email' => 'carmen.t@email.com',       'phone' => '09247788990', 'address' => '33 Taft Ave, Manila',        'pet_name' => 'Nala',     'pet_species' => 'Dog',    'pet_breed' => 'Pomeranian',         'notes' => 'Follows up consistently.'],
            ['first_name' => 'Andrei',  'last_name' => 'Ramos',     'email' => 'andrei.r@email.com',       'phone' => '09259900112', 'address' => '67 EDSA, Caloocan',          'pet_name' => 'Simba',    'pet_species' => 'Cat',    'pet_breed' => 'British Shorthair',  'notes' => 'Prefers afternoon visits.'],
            ['first_name' => 'Karen',   'last_name' => 'Lim',       'email' => 'karen.lim@email.com',      'phone' => '09261122334', 'address' => '90 Aurora Blvd, QC',         'pet_name' => 'Charlie',  'pet_species' => 'Dog',    'pet_breed' => 'French Bulldog',     'notes' => 'Skin allergy issues.'],
            ['first_name' => 'Miguel',  'last_name' => 'Fernandez', 'email' => 'miguel.f@email.com',       'phone' => '09273344556', 'address' => '12 Roxas Blvd, Manila',      'pet_name' => 'Pepper',   'pet_species' => 'Cat',    'pet_breed' => 'Ragdoll',            'notes' => null],
            ['first_name' => 'Bianca',  'last_name' => 'Navarro',   'email' => 'bianca.n@email.com',       'phone' => '09285566778', 'address' => '44 Quezon Ave, QC',          'pet_name' => 'Thor',     'pet_species' => 'Dog',    'pet_breed' => 'Husky',              'notes' => 'Needs regular grooming.'],
            ['first_name' => 'Leo',     'last_name' => 'Castillo',  'email' => 'leo.c@email.com',          'phone' => '09297788990', 'address' => '160 Commonwealth, QC',       'pet_name' => 'Oreo',     'pet_species' => 'Cat',    'pet_breed' => 'Tuxedo',             'notes' => 'Indoor cat only.'],
            ['first_name' => 'Patricia','last_name' => 'Aquino',    'email' => 'patricia.a@email.com',     'phone' => '09301122334', 'address' => '22 España Blvd, Manila',     'pet_name' => 'Daisy',    'pet_species' => 'Dog',    'pet_breed' => 'Poodle',             'notes' => 'Vaccination schedule up to date.'],
        ];

        $clients = collect($clientsData)->map(fn ($data) => Client::create($data));

        // ─── Service Types ──────────────────────────────────
        $serviceTypes = [
            'Grooming', 'Vaccination', 'Checkups', 'Dental', 'Surgery',
        ];

        $times = ['08:00','08:30','09:00','09:30','10:00','10:30','11:00','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30'];

        // ─── Appointments ───────────────────────────────────
        $appointments = collect();

        // Past completed appointments (last 60 days)
        for ($i = 0; $i < 20; $i++) {
            $date = now()->subDays(rand(2, 60));
            $apt = Appointment::create([
                'client_id'        => $clients->random()->id,
                'staff_id'         => $staffMembers->random()->id,
                'service_type'     => $serviceTypes[array_rand($serviceTypes)],
                'appointment_date' => $date->toDateString(),
                'appointment_time' => $times[array_rand($times)],
                'status'           => Appointment::STATUS_COMPLETED,
                'notes'            => $this->randomNote(),
                'created_by'       => $receptionists->random()->id,
            ]);
            $appointments->push($apt);
        }

        // Past cancelled appointments
        for ($i = 0; $i < 5; $i++) {
            $date = now()->subDays(rand(3, 45));
            $apt = Appointment::create([
                'client_id'        => $clients->random()->id,
                'staff_id'         => $staffMembers->random()->id,
                'service_type'     => $serviceTypes[array_rand($serviceTypes)],
                'appointment_date' => $date->toDateString(),
                'appointment_time' => $times[array_rand($times)],
                'status'           => Appointment::STATUS_CANCELLED,
                'notes'            => 'Client requested cancellation.',
                'created_by'       => $receptionists->random()->id,
            ]);
            $appointments->push($apt);
        }

        // Past no-shows
        for ($i = 0; $i < 3; $i++) {
            $date = now()->subDays(rand(5, 30));
            $apt = Appointment::create([
                'client_id'        => $clients->random()->id,
                'staff_id'         => $staffMembers->random()->id,
                'service_type'     => $serviceTypes[array_rand($serviceTypes)],
                'appointment_date' => $date->toDateString(),
                'appointment_time' => $times[array_rand($times)],
                'status'           => Appointment::STATUS_NO_SHOW,
                'notes'            => null,
                'created_by'       => $receptionists->random()->id,
            ]);
            $appointments->push($apt);
        }

        // Today's appointments
        $todayStatuses = [
            Appointment::STATUS_SCHEDULED,
            Appointment::STATUS_CONFIRMED,
            Appointment::STATUS_CONFIRMED,
            Appointment::STATUS_COMPLETED,
            Appointment::STATUS_SCHEDULED,
        ];
        for ($i = 0; $i < 5; $i++) {
            $apt = Appointment::create([
                'client_id'        => $clients[$i]->id,
                'staff_id'         => $staffMembers[$i % $staffMembers->count()]->id,
                'service_type'     => $serviceTypes[$i],
                'appointment_date' => now()->toDateString(),
                'appointment_time' => $times[$i + 2],
                'status'           => $todayStatuses[$i],
                'notes'            => $this->randomNote(),
                'created_by'       => $receptionists->random()->id,
            ]);
            $appointments->push($apt);
        }

        // Future scheduled appointments (next 14 days)
        for ($i = 0; $i < 10; $i++) {
            $date = now()->addDays(rand(1, 14));
            $status = $i < 5 ? Appointment::STATUS_SCHEDULED : Appointment::STATUS_CONFIRMED;
            $apt = Appointment::create([
                'client_id'        => $clients->random()->id,
                'staff_id'         => $staffMembers->random()->id,
                'service_type'     => $serviceTypes[array_rand($serviceTypes)],
                'appointment_date' => $date->toDateString(),
                'appointment_time' => $times[array_rand($times)],
                'status'           => $status,
                'notes'            => $this->randomNote(),
                'created_by'       => $receptionists->random()->id,
            ]);
            $appointments->push($apt);
        }

        // ─── Service Records (for completed appointments) ───
        $completedApts = $appointments->where('status', Appointment::STATUS_COMPLETED);
        $descriptions = [
            'General physical examination completed. Vitals normal.',
            'Vaccination administered. No adverse reactions observed.',
            'Dental cleaning performed. Minor tartar buildup removed.',
            'Full grooming session completed. Coat trimmed and nails clipped.',
            'Skin examination done. Prescribed medicated shampoo for 2 weeks.',
            'Blood work results reviewed. All values within normal range.',
            'Deworming medication administered. Follow up in 3 months.',
            'X-Ray taken. No fractures detected.',
            'Wound cleaned and bandaged. Antibiotics prescribed.',
            'Routine checkup complete. Pet is in good health.',
        ];
        $remarks = [
            'Schedule follow-up in 2 weeks.',
            'Next vaccination due in 3 months.',
            'Monitor eating habits for the next few days.',
            'Return if symptoms persist.',
            'No further treatment needed at this time.',
            'Recommend switching to senior pet food.',
            'Continue current medication for 7 more days.',
            null,
            null,
        ];

        foreach ($completedApts as $apt) {
            ServiceRecord::create([
                'appointment_id' => $apt->id,
                'client_id'      => $apt->client_id,
                'staff_id'       => $apt->staff_id,
                'description'    => $descriptions[array_rand($descriptions)],
                'service_date'   => $apt->appointment_date,
                'remarks'        => $remarks[array_rand($remarks)],
            ]);
        }
    }

    private function randomNote(): ?string
    {
        $notes = [
            'Please arrive 10 minutes early.',
            'Client has multiple pets.',
            'Bring previous vaccination records.',
            'First time visit.',
            'Follow-up from previous consultation.',
            'Pet may need sedation for procedure.',
            'Owner requested afternoon slot.',
            null,
            null,
            null,
        ];

        return $notes[array_rand($notes)];
    }
}
