<?php

namespace App\Services;

use App\Models\Employee;
use App\Services\Traits\ClearNullInputsTrait;

class EmployeeService extends AbstractService
{

    use ClearNullInputsTrait;

    private $employeeModel = null;

    /**
     * OrderService constructor.
     */
    public function __construct()
    {
        $this->employeeModel = new Employee();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUuid($uuid) {
        return $this->employeeModel->where('uuid', '=', $uuid)->first();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getByUserUuid($uuid) {
        return $this->employeeModel->where('user_uuid', '=', $uuid)->first();
    }

}