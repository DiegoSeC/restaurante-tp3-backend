<?php

namespace App\Http\Controllers;

use App\Exceptions\Classes\NotFoundException;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Serializers\CustomSerializer;
use App\Services\EmployeeService;
use App\Transformers\EmployeeTransformer;

class EmployeeController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $employeeService;

    /**
     * EmployeeController constructor.
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     */
    public function get($uuid) {

        $item = $this->employeeService->getByUuid($uuid);

        if(!is_null($item)) {
            $response = fractal()->item($item, new EmployeeTransformer(), 'data')
                ->serializeWith(new CustomSerializer())
                ->parseIncludes(['products'])
                ->toArray();

            return $this->responseOK($response);
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     */
    public function getByUserUuid($uuid) {
        $item = $this->employeeService->getByUserUuid($uuid);

        if(!is_null($item)) {
            $response = fractal()->item($item, new EmployeeTransformer(), 'data')
                ->serializeWith(new CustomSerializer())
                ->parseIncludes(['products'])
                ->toArray();

            return $this->responseOK($response);
        } else {
            throw new NotFoundException();
        }
    }


}
