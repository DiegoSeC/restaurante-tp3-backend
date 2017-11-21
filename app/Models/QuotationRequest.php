<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationRequest extends Model
{

    const QUOTATION_REQUEST_STATUS_PENDING = 'pending';
    const QUOTATION_REQUEST_STATUS_COMPLETED = 'completed';
    const QUOTATION_REQUEST_STATUS_CANCELED = 'canceled';

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
        return $this->belongsToMany('App\Models\Product', 'quotation_request_has_products')->withPivot('quantity')->withTimestamps();
    }

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

}
