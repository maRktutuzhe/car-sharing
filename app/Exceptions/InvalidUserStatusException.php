<?php

namespace App\Exceptions;

use Exception;

class InvalidUserStatusException extends Exception
{
    /**
     * Get the exception's context information.
     *
     * @return string
     */
    public function __construct($status)
    {
        $message = 'На данный момент вы не имеете права арендовать автомобиль. Ваш статус: ' . $status;
        parent::__construct($message);
    }
}
