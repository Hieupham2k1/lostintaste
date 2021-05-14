<?php

namespace App\Models\LostinTaste;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function Subject(){
        return $this->belongsto('App\User','subject_id');
    }
    public function Object(){
        return $this->belongsto('App\User','object_id');
    }
}
