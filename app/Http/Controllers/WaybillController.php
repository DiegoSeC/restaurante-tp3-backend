<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ResponseTrait;
use App\Serializers\CustomSerializer;
use App\Services\WaybillService;
use App\Transformers\WaybillTransformer;
use Illuminate\Http\Request;

class WaybillController extends Controller
{

    use ResponseTrait;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $data = $this->waybillService->getAll();

        $response = fractal()->collection($data, new WaybillTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }


    public function get($uuid) {
        $item = $this->waybillService->getByUuid($uuid);

        $response = fractal()->item($item, new WaybillTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request) {
        $item = $this->waybillService->create($request->all());

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
    public function put(Request $request, $uuid) {
        $item = $this->waybillService->update($uuid, $request->all());

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
        $item = $this->waybillService->update($uuid, $request->all());

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
        $item = $this->waybillService->delete($uuid);

        return $this->responseNoContent();
    }

}
