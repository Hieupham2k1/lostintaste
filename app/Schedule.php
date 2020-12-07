<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['time', 'mode', 'user_id', 'post_id'];

    public function Post(){
        return $this->belongsTo('App\Post');
    }

    public function User(){
        return $this->belongsto('App\User');
    }

    public function Attendee(){
        return $this->hasMany('App\Attendee');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($schedule) { // before delete() method call this
             foreach($schedule->attendee as $attendee){
                 $attendee->delete();
             }
        });
    }
}
