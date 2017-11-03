<?php

namespace App\Transformers;

use App\Models\Waybill;
use League\Fractal\TransformerAbstract;

class WaybillTransformer extends TransformerAbstract
{

    public function transform(Waybill $waybill)
    {

        $response = [
            'uuid' => (string)$waybill->uuid
        ];

        return $response;
    }
}