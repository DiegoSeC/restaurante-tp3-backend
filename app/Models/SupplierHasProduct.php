<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierHasProduct extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id', 'product_id'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

}
