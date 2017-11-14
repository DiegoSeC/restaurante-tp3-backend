<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Serializers\CustomSerializer;
use App\Services\WarehouseService;
use App\Transformers\WarehouseTransformer;

class WarehouseController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $warehouseService;

    /**
     * WarehouseController constructor.
     * @param WarehouseService $warehouseService
     */
    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $data = $this->warehouseService->getAll();

        $response = fractal()->collection($data, new WarehouseTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }


    

}
