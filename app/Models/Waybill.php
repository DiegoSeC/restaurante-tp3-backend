<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waybill extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    const DOCUMENT_NUMBER_PREFIX = 'GR';

    const WAYBILL_STATUS_ACTIVE = 'active';
    const WAYBILL_STATUS_CANCELED = 'canceled';

    const WAYBILL_DELIVERY_STATUS_PENDING = 'pending';
    const WAYBILL_DELIVERY_STATUS_PROGRESS = 'progress';
    const WAYBILL_DELIVERY_STATUS_COMPLETED = 'completed';
    const WAYBILL_DELIVERY_STATUS_CANCELED = 'canceled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'carrier_id', 'truck_id', 'warehouse_from_id', 'warehouse_to_id', 'date_time', 'comment', 'status', 'delivery_status', 'order_id', 'document_number'
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

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'waybill_has_products')->withPivot('quantity')->withTimestamps();
    }
}
