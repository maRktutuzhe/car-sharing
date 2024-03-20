<?php
namespace App\Enums;

use Spatie\Enum\Enum;

class Event extends Enum
{
    public static function values(): array
    {
        return [
            'start' => 'начало аренды',
            'end' => 'конец аренды',
        ];
    }


}
