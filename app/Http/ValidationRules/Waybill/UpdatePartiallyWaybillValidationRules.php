<?php

namespace App\Http\ValidationRules\Waybill;

class UpdatePartiallyWaybillValidationRules
{

    public static function rules() {
        return [
            'delivery_status' => 'in:pending,progress,completed'
        ];
    }

}