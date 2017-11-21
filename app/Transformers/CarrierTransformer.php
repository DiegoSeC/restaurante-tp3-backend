<?php

namespace App\Transformers;

use App\Models\Carrier;
use League\Fractal\TransformerAbstract;

class CarrierTransformer extends TransformerAbstract
{

    public function transform(Carrier $carrier)
    {

        $employee = $carrier->employee;

        $response = [
            'uuid' => $carrier->uuid,
            'driver_license' => $carrier->driver_license,
            'employee' => [
                'document_number' => $employee->document_number,
                'name' => $employee->name,
                'lastname' => $employee->last_name
            ]
        ];

        return $response;
    }
}