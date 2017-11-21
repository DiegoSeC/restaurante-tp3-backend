<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Serializers\CustomSerializer;
use App\Services\CarrierService;
use App\Transformers\CarrierTransformer;

class CarrierController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $carrierService;

    /**
     * CarrierController constructor.
     * @param CarrierService $carrierService
     */
    public function __construct(CarrierService $carrierService)
    {
        $this->carrierService = $carrierService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $data = $this->carrierService->getAll();

        $response = fractal()->collection($data, new CarrierTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }




}
