<?php

namespace App\Exceptions;

use Throwable;

class UnAuthenticatedException extends \Exception
{
    public function __construct($message = "Unauthenticated", $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

