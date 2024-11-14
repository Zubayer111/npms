<?php

namespace Database\Factories;

use App\Models\Diseases;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diseases>
 */
class DiseasesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Diseases::class;
    public function definition(): array
    {
        return [
            'disease_name' => $this->faker->unique()->word(),
            'description'  => $this->faker->sentence(),
            'status'       => $this->faker->randomElement(['active', 'inactive']),
            'created_by'   => $this->faker->randomDigit(),
            'updated_by'   => $this->faker->randomDigit(),
        ];
    }
}
