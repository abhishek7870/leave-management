<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

  protected $fillable = ['first_name','last_name','email','mobile_no','is_admin','allotted_casual_leaves','allotted_sick_leaves','allotted_privilage_leaves','allowted_leave_without_pay','password'];
  protected $dates = ['created_at','updated_at'];

  public function leaves()
  {
      return $this->hasMany('App\Leave','user_id');
  }

}