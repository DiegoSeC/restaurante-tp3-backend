<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'warehouse_id', 'document_number'
    ];

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'order_has_products')->withPivot('quantity');
    }

    public function warehouse() {
        return $this->belongsTo('App\Models\Warehouse');
    }

}
