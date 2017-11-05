<?php

namespace App\Services;

use App\Exceptions\Classes\NotFoundException;
use App\Models\Waybill;

class WaybillService implements CrudServiceInterface
{

    private $waybillModel = null;

    /**
     * WaybillService constructor.
     */
    public function __construct()
    {
        $this->waybillModel = new Waybill();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll() {
        return $this->waybillModel->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->waybillModel->where('uuid', '=', $uuid)->first();
    }

    /**
     * @param $data
     * @return array
     */
    public function create($data) {
        return [];
    }

    /**
     * @param $uuid
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @throws NotFoundException
     */
    public function update($uuid, $data) {
        $waybill = $this->waybillModel->where('uuid', '=', $uuid)->first();

        if(is_null($waybill)) {
            throw new NotFoundException();
        }

        $waybill->fill($data);
        $waybill->save();

        return $waybill;
    }

    /**
     * @param $uuid
     * @return array
     */
    public function delete($uuid) {
        return [];
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByCarrierUuid($uuid) {
        return $this->waybillModel
            ->select('waybills.*')
            ->join('carriers', 'waybills.carrier_id', '=','carriers.id')
            ->where('carriers.uuid', '=', $uuid)
            ->get();
    }


}