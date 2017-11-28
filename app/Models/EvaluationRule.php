<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluationRule extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'description', 'percentage'
    ];

    public function suppliers() {
        return $this->belongsToMany('App\Models\Supplier', 'supplier_has_evaluation_rules')->withPivot('value')->withTimestamps();
    }
}
