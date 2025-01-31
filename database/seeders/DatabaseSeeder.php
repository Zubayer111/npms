<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Diseases;
use App\Models\DoctorsProfile;
use App\Models\PatientsProfile;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(AdminSeeder::class);
        // DoctorsProfile::factory()->count(10)->create();
        // PatientsProfile::factory()->count(10)->create();
        // Diseases::factory()->count(20)->create();
    }
}
