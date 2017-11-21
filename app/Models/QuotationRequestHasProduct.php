<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationRequestHasProduct extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quotation_request_id', 'product_id', 'quantity'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function quotation_request() {
        return $this->belongsTo('App\Models\QuotationRequest');
    }

}
