<?php

namespace App\Exceptions\Classes;


use Throwable;

class NotCreatedException extends AbstractException
{

    public function __construct($message = null, Throwable $previous = null)
    {
        $message = (!is_null($message))? $message : trans('exception.bad_request');
        parent::__construct($message, 422, $previous);
    }

}