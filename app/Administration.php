<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administration extends Model
{
    
    protected $fillable = ['name','email','mobile_no','address'];

    protected $dates = ['created_at','updated_at'];

    public function user1s()
    {
    	return $this->hasMany('App\User1','administration_id');
    }
}
