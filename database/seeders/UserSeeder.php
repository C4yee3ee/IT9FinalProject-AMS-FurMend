<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@furmend.com'],
            [
                'first_name' => 'James',
                'last_name' => 'Wilson',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'phone' => '09171001001',
                'specialization' => 'Veterinary Medicine',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'reception@furmend.com'],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'password' => Hash::make('password'),
                'role' => User::ROLE_RECEPTIONIST,
                'phone' => '09171002002',
                'specialization' => null,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'mark@furmend.com'],
            [
                'first_name' => 'Mark',
                'last_name' => 'Reyes',
                'password' => Hash::make('password'),
                'role' => User::ROLE_STAFF,
                'phone' => '09171003003',
                'specialization' => 'Surgery & Orthopedics',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'anna@furmend.com'],
            [
                'first_name' => 'Anna',
                'last_name' => 'Cruz',
                'password' => Hash::make('password'),
                'role' => User::ROLE_STAFF,
                'phone' => '09171004004',
                'specialization' => 'Dermatology',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'carlos@furmend.com'],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Garcia',
                'password' => Hash::make('password'),
                'role' => User::ROLE_STAFF,
                'phone' => '09171005005',
                'specialization' => 'Internal Medicine',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'lisa@furmend.com'],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Mendoza',
                'password' => Hash::make('password'),
                'role' => User::ROLE_RECEPTIONIST,
                'phone' => '09171006006',
                'specialization' => null,
                'is_active' => true,
            ]
        );
    }
}
