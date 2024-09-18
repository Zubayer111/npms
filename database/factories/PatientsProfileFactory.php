<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\PatientsProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientsProfile>
 */
class PatientsProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PatientsProfile::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'reference_by' => User::factory(),
            'reference_time' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'reference_note' => $this->faker->text(200),
            'title' => $this->faker->title,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'middle_name' => $this->faker->optional()->firstName,
            'email' => $this->faker->optional()->safeEmail,
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'marital_status' => $this->faker->randomElement(['Married', 'Unmarried', 'Divorced', 'Separated', 'Widowed', 'Single', 'Life Partner']),
            'dob' => $this->faker->dateTimeBetween('-70 years', '-18 years'),
            'height' => $this->faker->randomFloat(2, 1.5, 2),  // height in meters
            'weight' => $this->faker->randomFloat(2, 50, 120),  // weight in kg
            'bmi' => $this->faker->randomFloat(2, 15, 40),
            'address_one' => $this->faker->address,
            'address_two' => $this->faker->optional()->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zipCode' => $this->faker->postcode,
            'phone_number' => $this->faker->phoneNumber,
            'history' => $this->faker->text(300),
            'employer_details' => $this->faker->optional()->text(200),
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'economical_status' => $this->faker->randomElement(['rich', 'middle class', 'poor']),
            'smoking_status' => $this->faker->randomElement(['smoker', 'non smoker']),
            'alcohole_status' => $this->faker->randomElement(['alcoholic', 'non alcoholic']),
            'status' => 'active',
            'patient_type' => $this->faker->randomElement(['system-patient', 'vendor-patient']),
            'profile_photo' => $this->faker->imageUrl(640, 480, 'people'),
            'deleted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
