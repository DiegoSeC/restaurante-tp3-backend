<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class OrderService
{

    private $orderModel = null;
    private $productModel = null;

    /**
     * OrderService constructor.
     */
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->productModel = new Product();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->orderModel->orderBy('created_at', 'desc')->get();
    }
}