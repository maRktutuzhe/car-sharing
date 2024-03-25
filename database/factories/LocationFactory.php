<?php

namespace Database\Factories;

use App\Casts\GeoJson;
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
        // Генерация случайных координат
        $latitude = fake()->latitude(51, 52);
        $longitude = fake()->longitude(54, 56);
        $geoJson = new GeoJson();
        $coordinates = $geoJson->set(null, null, "$latitude $longitude", null);
        return [
            'car_id' => Car::inRandomOrder()->first(),
            'coordinates' =>  $coordinates
        ];
    }
}
