<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{

    private $productModel = null;

    /**
     * WaybillService constructor.
     */
    public function __construct()
    {
        $this->productModel = new Product();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->productModel->orderBy('created_at', 'desc')->get();
    }
}