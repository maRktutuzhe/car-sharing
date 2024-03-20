<?php

namespace Database\Factories;

use App\Models\CarMake;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'number' => fake()->regexify('[A-Z]{1}[0-9]{3}[A-Z]{2}[0-9]{2}'),
            'carmake_id' => CarMake::inRandomOrder()->first(),
            'color' => fake()->colorName(),
            'status' => fake()->randomElement(['в аренде', 'свободна', 'недоступна']),
            'password' => Hash::make('carPassword'),
        ];
    }
}
