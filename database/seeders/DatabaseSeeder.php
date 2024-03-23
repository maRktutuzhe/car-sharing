<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Car;
use App\Models\Location;
use App\Models\Price;
use App\Models\Rent;
use App\Models\User;
use Database\Seeders\CarMakesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CarMakesSeeder::class);

        User::factory()->create(['email' => 'mb89510335133@gmail.com']);
        User::factory(10)->create();
        Car::factory(10)->has(Location::factory())->create();
        Price::factory(5)->create();
        // Location::factory(5)->create();
        Rent::factory(10)->create();
    }
}
