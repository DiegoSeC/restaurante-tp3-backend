<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierHasEvaluationRule extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id', 'evaluation_rule_id', 'value'
    ];

    public function evaluation_rule() {
        return $this->belongsTo('App\Models\EvaluationRule');
    }

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }
}
