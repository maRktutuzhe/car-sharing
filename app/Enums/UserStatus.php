<?php
namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * Represents the status of a user
 *
 * This enum class defines the possible statuses a user can have.
 *
 * @method static self active()
 * @method static self inactive()
 * @method static self blocked()
 * @method static self suspicious()
 * @method static self premium()
 */
class UserStatus extends Enum
{
    public static function values(): array
    {
        return [
            'active' => 'active',
            'inactive' => 'inactive',
            'blocked' => 'blocked',
            'suspicious' => 'suspicious',
            'premium' => 'premium'
        ];
    }


}
