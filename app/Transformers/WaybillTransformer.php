<?php

namespace App\Transformers;

use App\Models\Waybill;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class WaybillTransformer extends TransformerAbstract
{

    public function transform(Waybill $waybill)
    {

        $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $waybill->date_time);
        $carrier = $waybill->carrier;
        $employee = $carrier->employee;
        $truck = $waybill->truck;

        $response = [
            'uuid' => $waybill->uuid,
            'date' => $carbon->toDateString(),
            'time' => $carbon->toTimeString(),
            'carrier' => [
                'driver_license' => $carrier->driver_license,
                'name' => $employee->name,
                'last_name' => $employee->last_name
            ],
            'truck' => [
                'license_plate' => $truck->license_plate,
                'brand' => $truck->brand
            ],
            'comment' => $waybill->comment,
            'delivery_status' => (string) $waybill->delivery_status,
            'status' => (string) $waybill->status
        ];

        return $response;
    }
}