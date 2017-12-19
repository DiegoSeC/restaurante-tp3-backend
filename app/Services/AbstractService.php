<?php

namespace App\Services;


abstract class AbstractService
{

    protected $prefixDocumentNumber = null;

    /**
     * @param $number
     * @return string
     * @throws \Exception
     */
    protected function documentNumberGenerator($number) {
        if(is_null($this->prefixDocumentNumber)) {
            throw new \Exception('El prefijo de numeración no puede ser nulo');
        }

        $length  = 6;
        $prefix = $this->prefixDocumentNumber;
        return $prefix . date('y') . str_pad($number,$length,'0', STR_PAD_LEFT);
    }


}