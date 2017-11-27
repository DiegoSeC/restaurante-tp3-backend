<?php

namespace App\Http\ValidationRules\QuotationRequest;

class UpdatePartiallyQuotationRequestValidationRules
{

    public static function rules() {
        return [
            'order' => 'string|exists:orders,uuid',
            'products' => 'array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'status' => 'string|in:pending,completed,canceled',
        ];
    }

}