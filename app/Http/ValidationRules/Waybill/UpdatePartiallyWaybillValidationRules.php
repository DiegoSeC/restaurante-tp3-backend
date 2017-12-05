<?php

namespace App\Http\ValidationRules\Waybill;

class UpdatePartiallyWaybillValidationRules
{

    public static function rules() {
        return [
            'delivery_status' => 'string|in:pending,progress,completed,canceled',
            'comment' => 'string',
            'status' => 'string|in:active,canceled',
            'warehouse_from' => 'string|exists:warehouses,uuid',
            'warehouse_to' => 'string|exists:warehouses,uuid|different:warehouse_from',
            'transfer_guide' => 'exists:transfer_guides,uuid',
            'products' => 'array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'carrier' => 'exists:carriers,uuid',
            'truck' => 'exists:trucks,uuid'
        ];
    }

}