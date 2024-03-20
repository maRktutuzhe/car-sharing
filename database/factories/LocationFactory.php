<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Grimzy\LaravelMysqlSpatial\Types\Point;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //   // Генерация случайных координат
        $latitude = fake()->latitude(51, 52);
        $longitude = fake()->longitude(54, 56);
        
        return [
            'car_id' => Car::inRandomOrder()->first(),
            'coordinates' => DB::raw("ST_GeomFromText('POINT($latitude $longitude)', 4326)"),
        ];
    }
}
