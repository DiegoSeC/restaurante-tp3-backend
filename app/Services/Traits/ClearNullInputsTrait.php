<?php

namespace App\Services\Traits;


trait ClearNullInputsTrait
{

    protected function clearNullParams($input) {
        $result = [];
        foreach ($input as $item => $value) {
            if(!is_null($value)) {
                $result[$item] = $value;
            }
        }

        return $result;
    }

}