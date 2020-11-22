<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function Post(){
        return $this->belongsTo('App\Post');
    }
    public function User(){
        return $this->belongsto('App\User');
    }
    public function Attendee(){
        return $this->hasMany('App\Attendee');
    }
}
