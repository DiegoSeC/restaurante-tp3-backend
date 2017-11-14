<?php

namespace App\Http\ValidationRules\Order;

class CreateOrderValidationRules
{

    public static function rules() {
        return [
            'warehouse' => 'required|string|exists:warehouses,uuid',
            'products' => 'required|array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

}