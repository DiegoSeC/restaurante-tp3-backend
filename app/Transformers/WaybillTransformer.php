<?php

namespace App\Transformers;

use App\Models\Waybill;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class WaybillTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'products'
    ];

    public function transform(Waybill $waybill)
    {

        $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $waybill->date_time);
        $carrier = $waybill->carrier;
        $employee = $carrier->employee;
        $truck = $waybill->truck;
        $warehouseFrom = $waybill->warehouse_from;
        $warehouseTo = $waybill->warehouse_to;
        $transferGuide = $waybill->transfer_guide;

        if(isset($transferGuide) && !empty($transferGuide)) {
            $transferGuideArray = [
                'uuid' => $transferGuide->uuid,
                'document_number' => $transferGuide->document_number
            ];
        } else {
            $transferGuideArray = null;
        }

        $response = [
            'uuid' => $waybill->uuid,
            'document_number' => $waybill->document_number,
            'carrier' => [
                'uuid' => $carrier->uuid,
                'driver_license' => $carrier->driver_license,
                'name' => $employee->name,
                'last_name' => $employee->last_name
            ],
            'truck' => [
                'uuid' => $truck->uuid,
                'license_plate' => $truck->license_plate,
                'brand' => $truck->brand
            ],
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
            'transfer_guide' => $transferGuideArray,
            'comment' => $waybill->comment,
            'delivery_status' => (string) $waybill->delivery_status,
            'status' => (string) $waybill->status,
            'date' => $carbon->toDateString(),
            'time' => $carbon->toTimeString()
        ];

        return $response;
    }

    public function includeProducts(Waybill $waybill)
    {
        $products = $waybill->products()->get();
        return $this->collection($products, new WaybillProductTransformer(), false);
    }

}