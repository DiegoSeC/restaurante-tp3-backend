<?php

namespace App\Transformers;

use App\Models\Supplier;
use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'products'
    ];

    public function transform(Supplier $supplier)
    {
        $response = [
            'uuid' => $supplier->uuid,
            'document_number' => $supplier->document_number,
            'name' => $supplier->name,
            'contact_name' => $supplier->contact_name,
            'address' => $supplier->address,
            'phone_number' => $supplier->phone_number,
            'quantity_products' => $supplier->products()->count()
        ];

        return $response;
    }

    public function includeProducts(Supplier $supplier)
    {
        $products = $supplier->products()->get();
        return $this->collection($products, new SupplierProductTransformer(), false);
    }

}