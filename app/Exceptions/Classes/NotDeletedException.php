<?php

namespace App\Exceptions\Classes;


use Throwable;

class NotDeletedException extends AbstractException
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(trans('exception.not_deleted'), 422, $previous);
    }

}