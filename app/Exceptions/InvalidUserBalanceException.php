<?php

namespace App\Exceptions;

use Exception;

class InvalidUserBalanceException extends Exception
{
    /**
     * Get the exception's context information.
     *
     * @return string
     */
    public function __construct($balance)
    {
        $rub = floor($balance / 100);
        $cop = $balance % 100;
        $message = '10';
        if ($balance < 0) {
            $message = 'Сначала оплатите задолженность. Её сумма составляет: ' . $rub . '.' . $cop . ' рублей';
        } else {
            $message = 'Для аренды автомобиля на вашем счету должно быть не менее 1500.00 рублей. На данный момент на вашем счету: ' . $rub . '.' . $cop . ' рублей';
        }
        parent::__construct($message);
    }
}
