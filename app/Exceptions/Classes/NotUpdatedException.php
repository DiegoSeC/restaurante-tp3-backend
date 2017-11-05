<?php

namespace App\Exceptions\Classes;


use Throwable;

class NotUpdatedException extends AbstractException
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(trans('exception.not_updated'), 422, $previous);
    }

}