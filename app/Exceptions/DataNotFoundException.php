<?php

namespace App\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    protected $code = 404;
}
