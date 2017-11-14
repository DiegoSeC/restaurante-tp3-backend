<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{

    public function transform(Product $product)
    {

        $category = $product->product_category;

        $response = [
            'uuid' => $product->uuid,
            'sku' => $product->sku,
            'name' => $product->name,
            'description' => $product->description,
            'unit_of_measurement' => $product->unit_of_measurement,
            'category' => [
                'uuid' => $category->uuid,
                'name' => $category->name
            ]
        ];

        return $response;
    }
}