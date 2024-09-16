<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 active patients
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => 'Patient ' . $i,
                'email' => 'patient' . $i . '@example.com',
                'phone' => '123456789' . $i,
                'password' => Hash::make('password'),
                'otp' => rand(100000, 999999),
                'status' => 'active',
                'type' => 'Patient',
            ]);
        }
        // Create 50 active doctors
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => 'Doctor ' . $i,
                'email' => 'doctor' . $i . '@example.com',
                'phone' => '987654321' . $i,
                'password' => Hash::make('password'),
                'otp' => rand(100000, 999999),
                'status' => 'active',
                'type' => 'Doctor',
            ]);
        }
    }
}
