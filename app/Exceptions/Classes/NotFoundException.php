<?php

namespace App\Exceptions\Classes;


use Throwable;

class NotFoundException extends AbstractException
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(trans('exception.not_found'), 404, $previous);
    }

}