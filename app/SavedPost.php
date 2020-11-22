<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedPost extends Model
{
    protected $guard=[];
    public $timestamps= true;
    public function Post(){
        return $this->belongsTo('App\Post');
    }
    public function User(){
        return $this->belongsto('App\User');
    }
}
