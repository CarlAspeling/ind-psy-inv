<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResponseOption>
 */
class ResponseOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'response_set_id' => 1,
            'value' => fake()->numberBetween(1, 5),
            'label' => fake()->word(),
            'order' => fake()->numberBetween(1, 5),
        ];
    }
}
