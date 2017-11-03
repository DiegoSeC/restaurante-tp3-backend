<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use ModelUuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name'
    ];

    public function employees() {
        return $this->hasMany('App\Models\Employee');
    }
}
