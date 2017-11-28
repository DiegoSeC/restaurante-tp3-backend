<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'products'
    ];

    public function transform(Order $order)
    {
        $warehouse = $order->warehouse;

        $response = [
            'uuid' => $order->uuid,
            'document_number' => $order->document_number,
            'warehouse' => [
                'uuid' => $warehouse->uuid,
                'code' => $warehouse->code,
                'name' => $warehouse->name,
                'contact' => $warehouse->contact_name,
                'email' => $warehouse->contact_email,
                'address' => $warehouse->address,
                'phone_number' => $warehouse->contact_phone_number,
                'longitude' => $warehouse->longitude,
                'latitude' => $warehouse->latitude
            ],
            'status' => $order->status,
            'date' => $order->created_at->toDateString()
        ];

        return $response;
    }

    public function includeProducts(Order $order)
    {
        $products = $order->products()->get();
        return $this->collection($products, new OrderProductTransformer(), false);
    }
}
