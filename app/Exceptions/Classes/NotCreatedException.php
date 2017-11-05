<?php

namespace App\Exceptions\Classes;


use Throwable;

class NotCreatedException extends AbstractException
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(trans('exception.not_created'), 422, $previous);
    }

}