<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferGuideHasProduct extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transfer_guide_id', 'product_id', 'quantity'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function transfer_guide() {
        return $this->belongsTo('App\Models\TransferGuide');
    }

}
