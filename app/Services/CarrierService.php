<?php

namespace App\Services;

use App\Models\Carrier;

class CarrierService extends AbstractService
{

    private $carrierModel = null;

    /**
     * CarrierService constructor.
     */
    public function __construct()
    {
        $this->carrierModel = new Carrier();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->carrierModel->orderBy('created_at', 'desc')->get();
    }
}