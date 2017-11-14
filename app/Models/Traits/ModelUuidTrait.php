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

        return $uuid->string;
    }

}