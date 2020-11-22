<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $guard=[];
    public $timestamps= true;
    public function Schedule(){
        return $this->belongsTo('App\Schedule');
    }
    public function User(){
        return $this->belongsto('App\User');
    }
}
