<?php
namespace App\Enums;

use Spatie\Enum\Enum;

class UserStatus extends Enum
{
    public static function values(): array
    {
        return [
            'active' => 'активный',
            'inactive' => 'неактивный',
            'blocked' => 'заблокированный',
            'suspicious' => 'подозрительный',
            'premium' => 'премиум'
        ];
    }


}
