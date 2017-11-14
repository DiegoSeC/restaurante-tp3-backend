<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'code', 'contact_name', 'contact_email', 'contact_phone_number', 'status', 'latitude', 'longitude'
    ];

    public function waybills_from() {
        return $this->hasMany('App\Models\Waybill', 'warehouse_from_id');
    }

    public function waybills_to() {
        return $this->hasMany('App\Models\Waybill', 'warehouse_to_id');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'warehouse_has_products')->withPivot(['stock', 'minimum_stock', 'maximum_stock'])->withTimestamps();
    }

    public function inventory_movements() {
        return $this->hasMany('App\Models\InventoryMovement');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order');
    }
}
