<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrier extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'employee_id', 'driver_license'
    ];

    public function waybills() {
        return $this->hasMany('App\Models\Waybill');
    }

    public function employee() {
        return $this->belongsTo('App\Model\Employee');
    }
}
