<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User1 extends Model
{
    protected $fillable = ['name','email','casual_leaves','sick_leaves','study_leaves','maternity_leaves','mobile_no','request'];

    protected $dates = ['created_at','updated_at'];
}
