<?php

namespace App\Exceptions\Classes;


use Throwable;

abstract class AbstractException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}