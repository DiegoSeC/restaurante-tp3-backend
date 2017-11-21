<?php

namespace App\Http\Controllers;

use App\Exceptions\Classes\NotFoundException;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Serializers\CustomSerializer;
use App\Services\SupplierService;
use App\Transformers\SupplierTransformer;

class SupplierController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $supplierService;

    /**
     * SupplierController constructor.
     * @param SupplierService $supplierService
     */
    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $data = $this->supplierService->getAll();

        $response = fractal()->collection($data, new SupplierTransformer(), 'data')
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
        $item = $this->supplierService->getByUuid($uuid);

        if(!is_null($item)) {
            $response = fractal()->item($item, new SupplierTransformer(), 'data')
                ->serializeWith(new CustomSerializer())
                ->parseIncludes(['products'])
                ->toArray();

            return $this->responseOK($response);
        } else {
            throw new NotFoundException();
        }

    }



}
