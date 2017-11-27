<?php

namespace App\Http\Controllers;

use App\Exceptions\Classes\NotFoundException;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Http\ValidationRules\QuotationRequest\CreateQuotationRequestValidationRules;
use App\Http\ValidationRules\QuotationRequest\UpdatePartiallyQuotationRequestValidationRules;
use App\Http\ValidationRules\QuotationRequest\UpdateQuotationRequestValidationRules;
use App\Serializers\CustomSerializer;
use App\Services\QuotationRequestService;
use App\Transformers\QuotationRequestTransformer;
use Illuminate\Http\Request;

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


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request) {

        $this->validateRequestJson($request);
        $this->validateParams($request, CreateQuotationRequestValidationRules::rules());

        $input = $request->all();

        $item = $this->quotationRequestService->create($input);

        $response = fractal()->item($item, new QuotationRequestTransformer(), 'data')
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
        $this->validateParams($request, UpdateQuotationRequestValidationRules::rules());

        $input = $request->only([
            'order',
            'products',
            'status'
        ]);

        $item = $this->quotationRequestService->update($uuid, $input);

        $response = fractal()->item($item, new QuotationRequestTransformer(), 'data')
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
        $this->validateExistParams($request, UpdatePartiallyQuotationRequestValidationRules::rules());

        $input = $request->only([
            'order',
            'products',
            'status'
        ]);

        $item = $this->quotationRequestService->update($uuid, $input);

        $response = fractal()->item($item, new QuotationRequestTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function delete($uuid) {
        $this->quotationRequestService->delete($uuid);

        return $this->responseNoContent();
    }



}
