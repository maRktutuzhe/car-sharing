<?php

namespace Database\Factories;

use App\Enums\UserStatus;
use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusValues = UserStatus::values();
        $randomStatus = array_rand($statusValues);

        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => "7" . rand(1000000000, 9999999999),
            'city' => fake()->city(),
            'password' => Hash::make('password'),
            'status' => $randomStatus,
            'balance' => fake()->randomNumber(6, false),
        ];
    }
}
