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

        $response = [
            'uuid' => $transferGuide->uuid,
            'document_number' => $transferGuide->document_number,
            'status' => $transferGuide->status,
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