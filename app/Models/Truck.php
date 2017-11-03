<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

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
