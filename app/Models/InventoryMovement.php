<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryMovement extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'warehouse_id', 'comment', 'type'
    ];

    public function warehouse() {
        return $this->belongsTo('App\Models\Warehouse');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'inventory_movement_has_products')->withPivot('quantity')->withTimestamps();
    }

}
