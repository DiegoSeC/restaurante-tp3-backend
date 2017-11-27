<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class WaybillProductTransformer extends TransformerAbstract
{

    public function transform(Product $product)
    {
        $category = $product->product_category;
        $response = [
            'uuid' => $product->uuid,
            'sku' => $product->sku,
            'name' => $product->name,
            'unit_of_measurement' => $product->unit_of_measurement,
            'category' => $category->name,
            'quantity' => $product->pivot->quantity
        ];

        return $response;
    }
}