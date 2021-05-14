<?php

namespace App\Models\LostinTaste;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['time', 'mode', 'user_id', 'post_id'];
    
    public function User(){
        return $this->belongsto('App\User');
    }

    public function Post(){
        return $this->belongsTo('App\Models\LostinTaste\Post');
    }

    public function Attendee(){
        return $this->hasMany('App\Models\LostinTaste\Attendee');
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
