<?php

namespace App\Services;


interface CrudServiceInterface
{

    public function getAll();

    public function getByUuid($uuid);

    public function create($data);

    public function update($uuid, $data);

    public function delete($uuid);

}