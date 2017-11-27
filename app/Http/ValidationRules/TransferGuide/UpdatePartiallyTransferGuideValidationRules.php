<?php

namespace App\Http\ValidationRules\TransferGuide;

class UpdatePartiallyTransferGuideValidationRules
{

    public static function rules() {
        return [
            'order' => 'string|exists:orders,uuid',
            'products' => 'array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'status' => 'string|in:pending,completed,canceled',
            'warehouse_from' => 'string|exists:warehouses,uuid',
            'warehouse_to' => 'string|exists:warehouses,uuid|different:warehouse_from'
        ];
    }

}