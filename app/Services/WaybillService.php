<?php

namespace App\Services;

use App\Models\Waybill;

class WaybillService implements CrudServiceInterface
{

    public function getAll() {
        return Waybill::orderBy('created_at', 'desc')->get();
    }

    public function getByUuid($uuid) {
        return Waybill::where('uuid', '=', $uuid)->first();
    }

    public function create($data) {
        return [];
    }

    public function update($uuid, $data) {
        return [];
    }

    public function delete($uuid) {
        return [];
    }

}