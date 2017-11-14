<?php

namespace App\Http\Controllers;

use App\Exceptions\Classes\NotFoundException;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Http\ValidationRules\Order\CreateOrderValidationRules;
use App\Http\ValidationRules\Order\UpdateOrderValidationRules;
use App\Http\ValidationRules\Order\UpdatePartiallyOrderValidationRules;
use App\Serializers\CustomSerializer;
use App\Services\OrderService;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $orderService;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $data = $this->orderService->getAll();

        $response = fractal()->collection($data, new OrderTransformer(), 'data')
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
        $item = $this->orderService->getByUuid($uuid);

        if(!is_null($item)) {
            $response = fractal()->item($item, new OrderTransformer(), 'data')
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
        $this->validateParams($request, CreateOrderValidationRules::rules());

        $input = $request->all();

        $item = $this->orderService->create($input);

        $response = fractal()->item($item, new OrderTransformer(), 'data')
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
        $this->validateParams($request, UpdateOrderValidationRules::rules());

        $input = $request->only([
            'delivery_status',
            'comment',
            'status'
        ]);

        $item = $this->orderService->update($uuid, $input);

        $response = fractal()->item($item, new OrderTransformer(), 'data')
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
        $this->validateExistParams($request, UpdatePartiallyOrderValidationRules::rules());

        $input = $request->only([
            'delivery_status',
            'comment',
            'status'
        ]);

        $item = $this->orderService->update($uuid, $input);

        $response = fractal()->item($item, new OrderTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function delete($uuid) {
        $this->orderService->delete($uuid);

        return $this->responseNoContent();
    }


}
