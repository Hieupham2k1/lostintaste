<?php

namespace Modules\LostinTaste\Entities;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = ['user_id'];

    public function User(){
        return $this->belongsto('App\User'); // need to stay because User must be outside of module
    }
}
