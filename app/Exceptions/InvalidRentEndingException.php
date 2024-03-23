<?php

namespace App\Exceptions;

use App\Models\Car;
use Exception;

class InvalidRentEndingException extends Exception
{
    /**
     * Get the exception's context information.
     *
     * @return string
     */
    public function __construct(Car $car)
    {
        $message = 'Ошибка завершения аренды!!!';
        parent::__construct($message);
    }
}
