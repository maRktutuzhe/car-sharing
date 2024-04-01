<?php
namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * Represents the status of a car event.
 *
 * This enum class defines the possible statuses an event can have.
 *
 * @method static self start()
 * @method static self end()
 */
class Event extends Enum
{
    public static function values(): array
    {
        return [
            'start' => 'start',
            'end' => 'end',
        ];
    }
}
