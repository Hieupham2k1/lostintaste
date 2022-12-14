<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $lostintaste = "App\Models\LostinTaste\\";

    public function Info(){
        return $this->hasOne($this->lostintaste.'Info');
    }
    public function Post(){
        return $this->hasMany($this->lostintaste.'Post');
    }
    public function SavedPost(){
        return $this->hasMany($this->lostintaste.'SavedPost');
    }
    public function Schedule(){
        return $this->hasMany($this->lostintaste.'Schedule');
    }
    public function Attended(){
        return $this->hasMany($this->lostintaste.'Attendee');
    }
    public function Friend()
    {
        return $this->belongsToMany('App\User','friend','subject_id','object_id');
    }
}
