<?php

namespace App\Transformers;

use App\Models\Employee;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{

    public function transform(Employee $employee)
    {

        $warehouse = $employee->warehouse;
        $role = $employee->role;

        $response = [
            'uuid' => $employee->uuid,
            'document_number' => $employee->document_number,
            'name' => $employee->name,
            'last_name' => $employee->last_name,
            'address' => $employee->address,
            'phone_number' => $employee->phone_number,
            'email' => $employee->email,
            'status' => $employee->status,
            'warehouse' => [
                'uuid' => $warehouse->uuid,
                'code' => $warehouse->code,
                'name' => $warehouse->name,
                'contact' => $warehouse->contact_name,
                'email' => $warehouse->contact_email,
                'address' => $warehouse->address,
                'phone_number' => $warehouse->contact_phone_number,
                'longitude' => $warehouse->longitude,
                'latitude' => $warehouse->latitude
            ],
            'role' => [
                'uuid' => $role->uuid,
                'name' => $role->name
            ]
        ];

        return $response;
    }
}