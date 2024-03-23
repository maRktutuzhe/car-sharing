<?php

namespace App\Exceptions;

use Exception;

class InvalidCarStatusException extends Exception
{
    /**
     * Get the exception's context information.
     *
     * @return string
     */
    public function __construct()
    {
        $message = 'Этот автомобиль временно не доступен для аренды ';
        parent::__construct($message);
    }
}
