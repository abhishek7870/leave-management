<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
class User extends Authenticatable
{

  protected $fillable = ['first_name','last_name','email','mobile_no','is_admin','allotted_casual_leave','allotted_sick_leave','allotted_privilage_leave','allowted_leave_without_pay','password'];
  protected $dates = ['created_at','updated_at'];

  protected $hidden =['password'];

  public function leaves()
  {
      return $this->hasMany('App\Leave','user_id');
  }
  public static function authenticateUser($email, $password)
    {
        $user = User::where('email', '=', $email)->first();
    // dd($user);
            if($user)
            {
            	// dd($user);
                if (Hash::check($password, $user->password)) {
                   //dd($user);
                    return $user;
                } else {
                    return false;
                }
            }
            else{
                return false;
            }
    }
}
