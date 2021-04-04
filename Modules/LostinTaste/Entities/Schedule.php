<?php

namespace Modules\LostinTaste\Entities;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['time', 'mode', 'user_id', 'post_id'];
    
    public function User(){
        return $this->belongsto('App\User');
    }

    public function Post(){
        return $this->belongsTo('Modules\LostinTaste\Entities\Post');
    }

    public function Attendee(){
        return $this->hasMany('Modules\LostinTaste\Entities\Attendee');
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
