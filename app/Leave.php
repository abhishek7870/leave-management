<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Leave extends Model
{
    protected $fillable = ['start_date','end_date','reason','type_of_leaves','user_id','status'];

    protected $dates = ['created_at','updated_at']; 

    public function users()
    {
    	return $this->belongsTo('App\User','user_id');
    }
}
