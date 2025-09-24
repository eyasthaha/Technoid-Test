<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'partner_id' => \App\Models\Partner::factory(),
            'name' => $this->faker->company . ' ' . $this->faker->randomElement(['Hospital', 'Lab', 'Clinic']),
            'city' => $this->faker->city,
            'type' => $this->faker->randomElement(['hospital', 'lab', 'clinic']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
