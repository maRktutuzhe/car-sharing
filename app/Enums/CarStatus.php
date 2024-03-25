<?php
namespace App\Enums;

use Spatie\Enum\Enum;

class CarStatus extends Enum
{
    public static function values(): array
    {
        return [
            'free' => 'активный',
            'rented' => 'в аренде',
            'unavilable' => 'недоступен'
        ];
    }


}
