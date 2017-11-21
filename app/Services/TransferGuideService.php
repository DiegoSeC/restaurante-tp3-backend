<?php

namespace App\Services;

use App\Models\TransferGuide;

class TransferGuideService extends AbstractService
{

    private $transferGuideModel = null;

    /**
     * TransferGuideService constructor.
     */
    public function __construct()
    {
        $this->transferGuideModel = new TransferGuide();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->transferGuideModel->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->transferGuideModel->where('uuid', '=', $uuid)->first();
    }
}