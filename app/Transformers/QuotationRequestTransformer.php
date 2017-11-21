<?php

namespace App\Transformers;

use App\Models\QuotationRequest;
use League\Fractal\TransformerAbstract;

class QuotationRequestTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'products'
    ];

    public function transform(QuotationRequest $quotationRequest)
    {
        $order = $quotationRequest->order;

        $response = [
            'uuid' => $quotationRequest->uuid,
            'document_number' => $quotationRequest->document_number,
            'status' => $quotationRequest->status,
            'order' => [
                'uuid' => $order->uuid,
                'document_number' => $order->document_number,
            ],
            'date' => $quotationRequest->created_at->toDateString()

        ];

        return $response;
    }

    public function includeProducts(QuotationRequest $quotationRequest)
    {
        $products = $quotationRequest->products()->get();
        return $this->collection($products, new QuotationRequestProductTransformer(), false);
    }

}