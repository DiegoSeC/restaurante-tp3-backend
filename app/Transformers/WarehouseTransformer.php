<?php

namespace App\Transformers;

use App\Models\Product;
use App\Models\Warehouse;
use League\Fractal\TransformerAbstract;

class WarehouseTransformer extends TransformerAbstract
{

    public function transform(Warehouse $warehouse)
    {

        $response = [
            'uuid' => $warehouse->uuid,
            'code' => $warehouse->code,
            'contact_name' => $warehouse->contact_name,
            'contact_email' => $warehouse->contact_email,
            'contact_phone_number' => $warehouse->contact_phone_number,
            'latitude' => $warehouse->latitude,
            'longitude' => $warehouse->longitude,
            'status' => $warehouse->status
        ];

        return $response;
    }
}