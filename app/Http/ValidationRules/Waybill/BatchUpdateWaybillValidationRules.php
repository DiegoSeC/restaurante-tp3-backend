<?php

namespace App\Http\ValidationRules\Waybill;

class BatchUpdateWaybillValidationRules
{

    public static function rules() {
        return [
            'waybills' => 'required|array',
            'waybills.*' => 'string|exists:waybills,uuid',
            'delivery_status' => 'string|in:pending,progress,completed,canceled',
            'comment' => 'string',
            'status' => 'string|in:active,canceled'
        ];
    }

}