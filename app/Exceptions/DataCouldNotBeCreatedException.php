<?php

namespace App\Exceptions;

use Exception;

class DataCouldNotBeCreatedException extends Exception
{
    protected $code = 424;
}
