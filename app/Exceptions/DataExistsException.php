<?php

namespace App\Exceptions;

use Exception;

class DataExistsException extends \Exception
{
    protected $code = 409;
}
