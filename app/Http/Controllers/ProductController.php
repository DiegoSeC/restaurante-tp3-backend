<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ResponseTrait;
use App\Http\Controllers\Traits\ValidationRequestTrait;
use App\Serializers\CustomSerializer;
use App\Services\ProductService;
use App\Transformers\ProductTransformer;

class ProductController extends Controller
{

    use ResponseTrait;
    use ValidationRequestTrait;

    private $productService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {

        $data = $this->productService->getAll();

        $response = fractal()->collection($data, new ProductTransformer(), 'data')
            ->serializeWith(new CustomSerializer())
            ->toArray();

        return $this->responseOK($response);
    }


}
