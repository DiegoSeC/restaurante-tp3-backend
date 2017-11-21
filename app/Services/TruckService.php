<?php

namespace App\Services;

use App\Models\Truck;

class TruckService extends AbstractService
{

    private $truckModel = null;

    /**
     * TruckService constructor.
     */
    public function __construct()
    {
        $this->truckModel = new Truck();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->truckModel->orderBy('created_at', 'desc')->get();
    }
}