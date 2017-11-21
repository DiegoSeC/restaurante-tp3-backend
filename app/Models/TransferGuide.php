<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferGuide extends Model
{

    const TRANSFER_GUIDE_STATUS_ACTIVE = 'pending';
    const TRANSFER_GUIDE_STATUS_INACTIVE = 'completed';

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'order_id', 'document_number', 'status'
    ];

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'transfer_guide_has_products')->withPivot('quantity')->withTimestamps();
    }

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

}
