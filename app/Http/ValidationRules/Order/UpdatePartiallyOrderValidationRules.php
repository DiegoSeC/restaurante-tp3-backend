<?php

namespace App\Http\ValidationRules\Order;

class UpdatePartiallyOrderValidationRules
{

    public static function rules() {
        return [
            'warehouse' => 'string|exists:warehouses,uuid',
            'products' => 'array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'status' => 'string|in:pending,completed,canceled'
        ];
    }

}