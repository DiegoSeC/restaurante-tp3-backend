<?php

namespace App\Http\ValidationRules\TransferGuide;

class UpdateTransferGuideValidationRules
{

    public static function rules() {
        return [
            'order' => 'required|string|exists:orders,uuid',
            'products' => 'required|array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,inactive',
            'warehouse_from' => 'string|exists:warehouses,uuid',
            'warehouse_to' => 'string|exists:warehouses,uuid|different:warehouse_from'
        ];
    }

}