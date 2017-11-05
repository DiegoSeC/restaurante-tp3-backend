<?php

namespace App\Exceptions\Classes;


use Throwable;

class BadRequestException extends AbstractException
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(trans('exception.bad_request'), 400, $previous);
    }

}