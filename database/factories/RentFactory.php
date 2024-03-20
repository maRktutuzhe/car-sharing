<?php

namespace Database\Factories;

use App\Enums\Event;
use App\Models\Car;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rent>
 */
class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventValues = Event::values();
        $randomEvent = array_rand($eventValues, 1);


        return [
            'user_id' => User::inRandomOrder()->first(),
            'car_id' => Car::inRandomOrder()->first(),
            'event' => $randomEvent,
            'petrol' => fake()->randomFloat(),
            'location_id' => Location::inRandomOrder()->first(),
            'kilometer' => fake()->randomFloat(),
        ];
    }
}
