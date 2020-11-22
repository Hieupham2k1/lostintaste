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
    public function Info(){
        return $this->hasOne('App\Info');
    }
    public function Post(){
        return $this->hasMany('App\Post');
    }
    public function SavedPost(){
        return $this->hasMany('App\SavedPost');
    }
    public function Schedule(){
        return $this->hasMany('App\Schedule');
    }
    public function Attended(){
        return $this->hasMany('App\Attendee');
    }
    public function Friend()
    {
        return $this->belongsToMany('App\User','friend','subject_id','object_id');
    //('the object model name','pivot table','this model id',
    //'the object model id')
    }
}
