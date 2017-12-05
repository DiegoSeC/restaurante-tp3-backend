<?php

namespace App\Http\ValidationRules\Waybill;

class CreateWaybillValidationRules
{

    public static function rules() {
        return [
            'comment' => 'string',
            'warehouse_from' => 'required|string|exists:warehouses,uuid',
            'warehouse_to' => 'required|string|exists:warehouses,uuid|different:warehouse_from',
            'transfer_guide' => 'required|exists:transfer_guides,uuid',
            'products' => 'required|array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'carrier' => 'required|exists:carriers,uuid',
            'truck' => 'required|exists:trucks,uuid'
        ];
    }

}