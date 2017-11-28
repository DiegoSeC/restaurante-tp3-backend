<?php

namespace App\Transformers;

use App\Models\TransferGuide;
use League\Fractal\TransformerAbstract;

class TransferGuideTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'products'
    ];

    public function transform(TransferGuide $transferGuide)
    {
        $order = $transferGuide->order;
        $warehouseFrom = $transferGuide->warehouse_from;
        $warehouseTo = $transferGuide->warehouse_to;

        $response = [
            'uuid' => $transferGuide->uuid,
            'document_number' => $transferGuide->document_number,
            'status' => $transferGuide->status,
            'warehouse_from' => [
                'uuid' => $warehouseFrom->uuid,
                'code' => $warehouseFrom->code,
                'name' => $warehouseFrom->name,
                'contact' => $warehouseFrom->contact_name,
                'email' => $warehouseFrom->contact_email,
                'address' => $warehouseFrom->address,
                'phone_number' => $warehouseFrom->contact_phone_number,
                'longitude' => $warehouseFrom->longitude,
                'latitude' => $warehouseFrom->latitude
            ],
            'warehouse_to' => [
                'uuid' => $warehouseTo->uuid,
                'code' => $warehouseTo->code,
                'name' => $warehouseTo->name,
                'contact' => $warehouseTo->contact_name,
                'email' => $warehouseTo->contact_email,
                'address' => $warehouseTo->address,
                'phone_number' => $warehouseTo->contact_phone_number,
                'longitude' => $warehouseTo->longitude,
                'latitude' => $warehouseTo->latitude
            ],
            'order' => [
                'uuid' => $order->uuid,
                'document_number' => $order->document_number,
            ],
            'date' => $transferGuide->created_at->toDateString()

        ];

        return $response;
    }

    public function includeProducts(TransferGuide $transferGuide)
    {
        $products = $transferGuide->products()->get();
        return $this->collection($products, new TransferGuideProductTransformer(), false);
    }

}