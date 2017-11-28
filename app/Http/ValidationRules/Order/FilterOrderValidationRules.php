<?php

namespace App\Http\ValidationRules\Order;

class FilterOrderValidationRules
{

    public static function rules() {
        return [
            'status' => 'string|in:pending,completed,canceled'
        ];
    }

}