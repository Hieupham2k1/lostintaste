<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guard=[];
    public $timestamps= true;
    public function User(){
        return $this->belongsto('App\User');
    }
    public function SavedPost(){
        return $this->hasMany('App\SavedPost');
    }
    public function Schedule(){
        return $this->hasMany('App\Schedule');
    }
}
