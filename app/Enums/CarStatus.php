<?php
namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * Represents the status of a car.
 *
 * This enum class defines the possible statuses a car can have.
 *
 * @method static self free()
 * @method static self rented()
 * @method static self unavailable()
 */
class CarStatus extends Enum
{
    /**
     * Get all possible values as an associative array.
     *
     * @return array<string,string> Associative array of enum values.
     */
    public static function values(): array
    {
        return [
            'free' => 'free',
            'rented' => 'rented',
            'unavailable' => 'unavailable'
        ];
    }
}
