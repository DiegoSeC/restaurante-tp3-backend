<?php

namespace App\Transformers;

use App\Models\Truck;
use League\Fractal\TransformerAbstract;

class TruckTransformer extends TransformerAbstract
{

    public function transform(Truck $truck)
    {
        $response = [
            'uuid' => $truck->uuid,
            'license_plate' => $truck->license_plate,
            'brand' => $truck->brand
        ];

        return $response;
    }
}