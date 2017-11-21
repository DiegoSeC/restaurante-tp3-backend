<?php

namespace App\Services;

use App\Models\QuotationRequest;

class QuotationRequestService extends AbstractService
{

    private $quotationRequestModel = null;

    /**
     * QuotationRequestService constructor.
     */
    public function __construct()
    {
        $this->quotationRequestModel = new QuotationRequest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->quotationRequestModel->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->quotationRequestModel->where('uuid', '=', $uuid)->first();
    }
}