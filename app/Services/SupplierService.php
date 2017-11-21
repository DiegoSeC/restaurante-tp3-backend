<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierService extends AbstractService
{

    private $supplierModel = null;

    /**
     * SupplierService constructor.
     */
    public function __construct()
    {
        $this->supplierModel = new Supplier();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->supplierModel->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->supplierModel->where('uuid', '=', $uuid)->first();
    }
}