<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'document_number', 'name', 'contact_name', 'address', 'phone_number'
    ];

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'supplier_has_products')->withTimestamps();
    }
}
