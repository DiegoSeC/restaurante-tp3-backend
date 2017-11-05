<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Http\ValidationRules\Waybill\CreateWaybillValidationRules;
use App\Http\ValidationRules\Waybill\SearchWaybillValidationRules;
use App\Http\ValidationRules\Waybill\UpdatePartiallyWaybillValidationRules;
use App\Http\ValidationRules\Waybill\UpdateWaybillValidationRules;
use App\Serializers\CustomSerializer;
use App\Services\WaybillService;
use App\Transformers\WaybillTransformer;
use Illuminate\Http\Request;

class WaybillController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $waybillService;

    /**
     * WaybillController constructor.
     * @param WaybillService $waybillService
     */
    public function __construct(WaybillService $waybillService)
    {
        $this->waybillService = $waybillService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {

        $this->validateParams($request, SearchWaybillValidationRules::rules());

        $data = $this->waybillService->getAll();

        $response = fractal()->collection($data, new WaybillTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($uuid) {
        $item = $this->waybillService->getByUuid($uuid);

        if(!is_null($item)) {
            $response = fractal()->item($item, new WaybillTransformer(), 'data')
                ->serializeWith(new CustomSerializer())
                ->toArray();

            return $this->responseOK($response);
        } else {
            abort(404);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request) {

        $this->validateRequestJson($request);
        $this->validateParams($request, CreateWaybillValidationRules::rules());

        $input = $request->all();

        $item = $this->waybillService->create($input);

        $response = fractal()->item($item, new WaybillTransformer(), 'data')
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
        $this->validateParams($request, UpdateWaybillValidationRules::rules());

        $input = $request->all();

        $item = $this->waybillService->update($uuid, $input);

        $response = fractal()->item($item, new WaybillTransformer(), 'data')
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
        $this->validateExistParams($request, UpdatePartiallyWaybillValidationRules::rules());

        $input = $request->only([
           'delivery_status'
        ]);

        $item = $this->waybillService->update($uuid, $input);

        $response = fractal()->item($item, new WaybillTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function delete($uuid) {
        $this->waybillService->delete($uuid);

        return $this->responseNoContent();
    }

}
