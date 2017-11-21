<?php

namespace App\Http\Controllers;

use App\Exceptions\Classes\NotFoundException;
use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Serializers\CustomSerializer;
use App\Services\TransferGuideService;
use App\Transformers\TransferGuideTransformer;

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



}
