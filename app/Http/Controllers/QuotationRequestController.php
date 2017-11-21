<?php

namespace App\Http\Controllers;

use App\Exceptions\Classes\NotFoundException;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Serializers\CustomSerializer;
use App\Services\QuotationRequestService;
use App\Transformers\QuotationRequestTransformer;

class QuotationRequestController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $quotationRequestService;

    /**
     * QuotationRequestController constructor.
     * @param QuotationRequestService $quotationRequestService
     */
    public function __construct(QuotationRequestService $quotationRequestService)
    {
        $this->quotationRequestService = $quotationRequestService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $data = $this->quotationRequestService->getAll();

        $response = fractal()->collection($data, new QuotationRequestTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }



    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     */
    public function get($uuid) {
        $item = $this->quotationRequestService->getByUuid($uuid);

        if(!is_null($item)) {
            $response = fractal()->item($item, new QuotationRequestTransformer(), 'data')
                ->serializeWith(new CustomSerializer())
                ->parseIncludes(['products'])
                ->toArray();

            return $this->responseOK($response);
        } else {
            throw new NotFoundException();
        }

    }



}
