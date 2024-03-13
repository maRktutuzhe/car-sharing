<?php

namespace Database\Seeders;

use App\Models\CarMake;
use Illuminate\Database\Seeder;

class CarMakesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carMakes =  [
            [
                'name' => 'Toyota',
                'country' => 'Япония',
            ],
            [
                'name' => 'Chevrolet',
                'country' => 'США',
            ],
            [
                'name' => 'Kia',
                'country' => 'Корея',
            ],
            [
                'name' => 'Audi',
                'country' => 'Германия',
            ],
            [
                'name' => 'Lamborghini',
                'country' => 'Италия',
            ],
            [
                'name' => 'Peugeot',
                'country' => 'Франция',
            ],
            [
                'name' => 'Lada',
                'country' => 'Россия',
            ],
        ];
        foreach ($carMakes as $carMake) {
            CarMake::factory()->create($carMake);
        }
    }
}
