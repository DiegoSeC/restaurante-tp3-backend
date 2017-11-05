<?php

namespace App\Http\ValidationRules\Waybill;

class UpdatePartiallyWaybillValidationRules
{

    public static function rules() {
        return [
            'delivery_status' => 'string|in:pending,progress,completed,canceled',
            'comment' => 'string',
            'status' => 'string|in:active,canceled'
        ];
    }

}