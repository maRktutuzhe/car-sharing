<?php

namespace App\Exceptions;

use App\Models\Car;
use Exception;

class InvalidUserRentException extends Exception
{
    /**
     * Get the exception's context information.
     *
     * @return string
     */
    public function __construct(Car $car)
    {
        $message = 'Вы не можете арендовать новую машину, пока не закроете предыдущую аренду машины ' . $car->fullName();
        parent::__construct($message);
    }
}
