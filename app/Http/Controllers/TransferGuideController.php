<?php

namespace App\Http\Controllers;

use App\Exceptions\Classes\NotFoundException;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Http\ValidationRules\TransferGuide\CreateTransferGuideValidationRules;
use App\Http\ValidationRules\TransferGuide\UpdatePartiallyTransferGuideValidationRules;
use App\Http\ValidationRules\TransferGuide\UpdateTransferGuideValidationRules;
use App\Serializers\CustomSerializer;
use App\Services\TransferGuideService;
use App\Transformers\TransferGuideTransformer;
use Illuminate\Http\Request;

class TransferGuideController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $transferGuideService;

    /**
     * TransferGuideController constructor.
     * @param TransferGuideService $transferGuideService
     */
    public function __construct(TransferGuideService $transferGuideService)
    {
        $this->transferGuideService = $transferGuideService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $data = $this->transferGuideService->getAll();

        $response = fractal()->collection($data, new TransferGuideTransformer(), 'data')
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
        $item = $this->transferGuideService->getByUuid($uuid);

        if(!is_null($item)) {
            $response = fractal()->item($item, new TransferGuideTransformer(), 'data')
                ->serializeWith(new CustomSerializer())
                ->parseIncludes(['products'])
                ->toArray();

            return $this->responseOK($response);
        } else {
            throw new NotFoundException();
        }

    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request) {

        $this->validateRequestJson($request);
        $this->validateParams($request, CreateTransferGuideValidationRules::rules());

        $input = $request->all();

        $item = $this->transferGuideService->create($input);

        $response = fractal()->item($item, new TransferGuideTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response, 201);
    }


    /**
     * @param Request $request
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(Request $request, $uuid) {

        $this->validateRequestJson($request);
        $this->validateParams($request, UpdateTransferGuideValidationRules::rules());

        $input = $request->only([
            'order',
            'products',
            'status',
            'warehouse_from',
            'warehouse_to'
        ]);

        $item = $this->transferGuideService->update($uuid, $input);

        $response = fractal()->item($item, new TransferGuideTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }

    /**
     * @param Request $request
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function patch(Request $request, $uuid) {

        $this->validateRequestJson($request);
        $this->validateExistParams($request, UpdatePartiallyTransferGuideValidationRules::rules());

        $input = $request->only([
            'order',
            'products',
            'status',
            'warehouse_from',
            'warehouse_to'
        ]);

        $item = $this->transferGuideService->update($uuid, $input);

        $response = fractal()->item($item, new TransferGuideTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function delete($uuid) {
        $this->transferGuideService->delete($uuid);

        return $this->responseNoContent();
    }


}
