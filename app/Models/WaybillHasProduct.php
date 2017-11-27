<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaybillHasProduct extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'waybill_id', 'product_id', 'quantity'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function waybill() {
        return $this->belongsTo('App\Models\Waybill');
    }

}
