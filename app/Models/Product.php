<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'product_category_id', 'sku', 'name', 'description', 'unit_of_measurement'
    ];

    public function product_category() {
        return $this->belongsTo('App\Models\ProductCategory');
    }

    public function orders() {
        return $this->belongsToMany('App\Models\Order', 'order_has_products');
    }

    public function warehouses() {
        return $this->belongsToMany('App\Models\Warehouse', 'warehouse_has_products');
    }

    public function inventory_movements() {
        return $this->belongsToMany('App\Models\InventoryMovement', 'inventory_movements_has_products');
    }

}
