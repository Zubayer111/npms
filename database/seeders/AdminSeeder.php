<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'type' => 'Admin',
            'phone' => '123456789',
            'status' => 'active',
            'otp' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $data = DB::table('users')->insert([
            'name' => 'doctor',
            'email' => 'doctor@doctor.com',
            'password' => Hash::make('12345678'),
            'type' => 'Doctor',
            'phone' => '1234567812',
            'status' => 'active',
            'otp' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    }
}
