<?php

namespace App\Listeners;

use App\Events\CarCreated;
use App\Models\State;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCarState
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CarCreated $event): void
    {
        $states = [
            'car_id' => $event->id->id,
            'doors' => true,
            'engine' => true,
            'block' => true,
        ];
        $state = State::query()->create($states);
        echo( $state->doors);
    }
}
