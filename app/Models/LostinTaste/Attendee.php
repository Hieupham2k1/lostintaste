<?php

namespace App\Models\LostinTaste;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $guard = [];
    protected $fillable = ['user_id', 'schedule_id'];
    public $timestamps= true;

    public function User(){
        return $this->belongsto('App\User');
    }
    
    public function Schedule(){
        return $this->belongsTo('App\Models\LostinTaste\Schedule');
    }
    
}
