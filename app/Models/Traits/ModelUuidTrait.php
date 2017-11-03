<?php

namespace App\Models\Traits;

use Webpatser\Uuid\Uuid;

trait ModelUuidTrait
{

    /**
     * @return Uuid
     */
    public function generateUuid()
    {
        $uuidName = (string)$this->id . '-' . uniqid() . '-' . $this->table;
        $uuid = Uuid::generate(5, $uuidName, Uuid::NS_DNS);

        return $uuid;
    }


    /**
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $query = static::query();
        $model = $query->create($attributes);
        $model->uuid = $model->generateUuid();
        $model->save();
        return $model;
    }

}