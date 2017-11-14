<?php

namespace App\Services;

use App\Models\Product;

class ProductService extends AbstractService
{

    private $productModel = null;

    /**
     * ProductService constructor.
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