<?php

namespace App\Http\ValidationRules\QuotationRequest;

class UpdateQuotationRequestValidationRules
{

    public static function rules() {
        return [
            'order' => 'required|string|exists:orders,uuid',
            'products' => 'required|array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:pending,completed,canceled'
        ];
    }

}