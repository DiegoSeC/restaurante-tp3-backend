<?php

namespace App\Services;


abstract class AbstractService
{

    /**
     * @param $prefix
     * @param $length
     * @param $number
     * @return string
     */
    protected function documentNumberGenerator($prefix, $length, $number) {
        return $prefix . date('y') . str_pad($number,$length,'0', STR_PAD_LEFT);
    }


}