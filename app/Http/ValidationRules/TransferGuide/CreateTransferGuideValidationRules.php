<?php

namespace App\Http\ValidationRules\TransferGuide;

class CreateTransferGuideValidationRules
{

    public static function rules() {
        return [
            'order' => 'required|string|exists:orders,uuid',
            'products' => 'required|array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'warehouse_from' => 'required|string|exists:warehouses,uuid',
            'warehouse_to' => 'required|string|exists:warehouses,uuid|different:warehouse_from'
        ];
    }

}