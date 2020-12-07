<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guard = [];

    protected $fillable = ['name', 'kind', 'price', 'district', 'province', 'address', 'picture', 'time', 'user_id'];

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

    public static function boot() {
        parent::boot();

        static::deleting(function($post) { // before delete() method call this
             foreach($post->savedpost as $savedpost){
                 $savedpost->delete();
             }
             foreach($post->schedule as $schedule){
                 $schedule->delete();
             }
        });
    }
}
