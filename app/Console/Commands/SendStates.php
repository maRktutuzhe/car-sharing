<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\State;
use Illuminate\Console\Command;

class SendStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'car:send:states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate car states';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $randomCar = Car::inRandomOrder()->first();
        $states = [
            'car_id' => $randomCar->id,
            'doors' => fake()->boolean(),
            'engine' => fake()->boolean(),
            'block' => fake()->boolean(),
        ];
        State::query()->create($states);
        return 'ok';
    }
}
