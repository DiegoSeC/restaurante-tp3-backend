<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waybill extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'carrier_id', 'truck_id', 'warehouse_from_id', 'warehouse_to_id', 'date_time', 'comment', 'status', 'delivery_status'
    ];

    public function carrier() {
        return $this->belongsTo('App\Models\Carrier');
    }

    public function truck() {
        return $this->belongsTo('App\Models\Truck');
    }

    public function warehouse_from() {
        return $this->belongsTo('App\Models\Warehouse');
    }

    public function warehouse_to() {
        return $this->belongsTo('App\Models\Warehouse');
    }
}
