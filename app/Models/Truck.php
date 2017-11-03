<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{

    use ModelUuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'license_plate', 'brand'
    ];

    public function waybills() {
        return $this->hasMany('App\Models\Waybill');
    }
}
