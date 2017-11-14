<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHasProduct extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'order_id', 'product_id', 'quantity'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

}
