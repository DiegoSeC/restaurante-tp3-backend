<?php

namespace App\Models;

use App\Models\Traits\ModelUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{

    use ModelUuidTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'user_uuid', 'role_id', 'document_number', 'name', 'last_name', 'address', 'phone_number', 'email', 'status'
    ];

    public function carrier() {
        return $this->hasOne('App\Models\Carrier');
    }

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }
}
