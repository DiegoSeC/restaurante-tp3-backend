<?php

namespace App\Services;

use App\Models\Warehouse;

class WarehouseService
{

    private $warehouseModel = null;

    /**
     * WarehouseService constructor.
     */
    public function __construct()
    {
        $this->warehouseModel = new Warehouse();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->warehouseModel->orderBy('created_at', 'desc')->get();
    }
}