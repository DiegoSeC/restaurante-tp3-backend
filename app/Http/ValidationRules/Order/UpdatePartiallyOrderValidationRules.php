<?php

namespace App\Http\ValidationRules\Order;

class UpdatePartiallyOrderValidationRules
{

    public static function rules() {
        return [
            'delivery_status' => 'string|in:pending,progress,completed,canceled',
            'comment' => 'string',
            'status' => 'string|in:active,canceled'
        ];
    }

}