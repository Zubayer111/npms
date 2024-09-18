<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\DoctorsProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorsProfile>
 */
class DoctorsProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DoctorsProfile::class;
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),  
            'ref_id' => User::factory(),
            'title' => $this->faker->title,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'middle_name' => $this->faker->optional()->firstName,
            'phone_number' => $this->faker->phoneNumber,
            'address_one' => $this->faker->address,
            'address_two' => $this->faker->optional()->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'profile_photo' => $this->faker->imageUrl(640, 480, 'people'),  // Generates a random image URL
            'degree' => $this->faker->word,
            'speciality' => $this->faker->word,
            'organization' => $this->faker->company,
            'status' => 'active',  // Default status
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
