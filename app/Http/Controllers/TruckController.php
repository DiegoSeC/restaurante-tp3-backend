<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Serializers\CustomSerializer;
use App\Services\TruckService;
use App\Transformers\TruckTransformer;

class TruckController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $truckService;

    /**
     * TruckController constructor.
     * @param TruckService $truckService
     */
    public function __construct(TruckService $truckService)
    {
        $this->truckService = $truckService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $data = $this->truckService->getAll();

        $response = fractal()->collection($data, new TruckTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }




}
