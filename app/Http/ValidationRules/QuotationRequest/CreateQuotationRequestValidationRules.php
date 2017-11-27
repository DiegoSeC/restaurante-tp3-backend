<?php

namespace App\Http\ValidationRules\QuotationRequest;

class CreateQuotationRequestValidationRules
{

    public static function rules() {
        return [
            'order' => 'required|string|exists:orders,uuid',
            'products' => 'required|array',
            'products.*.uuid' => 'required|string|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1'
        ];
    }

}