<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferGuide extends Model
{

    const DOCUMENT_NUMBER_PREFIX = 'GS';

    const TRANSFER_GUIDE_STATUS_ACTIVE = 'active';
    const TRANSFER_GUIDE_STATUS_INACTIVE = 'inactive';

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'order_id', 'document_number', 'status', 'warehouse_from_id', 'warehouse_to_id', 'contact', 'comment'
    ];

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'transfer_guide_has_products')->withPivot('quantity')->withTimestamps();
    }

    public function waybill() {
        return $this->hasOne('App\Models\Waybill');
    }

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

    public function warehouse_from() {
        return $this->belongsTo('App\Models\Warehouse');
    }

    public function warehouse_to() {
        return $this->belongsTo('App\Models\Warehouse');
    }

}
