<?php

namespace App\Serializers;


use League\Fractal\Serializer\DataArraySerializer;

class CustomSerializer extends DataArraySerializer
{

    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return $resourceKey === false ? $data : [$resourceKey => $data];;
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array $data
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return $resourceKey === false ? $data : [$resourceKey => $data];
    }
}