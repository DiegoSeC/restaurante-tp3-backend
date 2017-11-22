<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class QuotationRequestProductTransformer extends TransformerAbstract
{

    public function transform(Product $product)
    {
        $suppliers = $product->suppliers()->get();

        $suppliersArray = [];
        foreach ($suppliers as $supplier) {
            $suppliersArray[] = [
                'uuid' => $supplier->uuid,
                'document_number' => $supplier->document_number,
                'name' => $supplier->name
            ];
        }

        $category = $product->product_category;
        $response = [
            'uuid' => $product->uuid,
            'sku' => $product->sku,
            'name' => $product->name,
            'unit_of_measurement' => $product->unit_of_measurement,
            'category' => $category->name,
            'quantity' => $product->pivot->quantity,
            'suppliers' => $suppliersArray
        ];

        return $response;
    }
}