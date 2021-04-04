<?php

namespace Modules\LostinTaste\Entities;

use Illuminate\Database\Eloquent\Model;

class SavedPost extends Model
{
    protected $guard = [];
    protected $fillable = ['mode', 'user_id', 'post_id'];
    public $timestamps = true;

    public function User(){
        return $this->belongsto('App\User');
    }
    
    public function Post(){
        return $this->belongsTo('Modules\LostinTaste\Entities\Post');
    }
    
}
