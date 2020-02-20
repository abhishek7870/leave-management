<?php

namespace App\Http\Controllers;
use Illuminate\Mail\Mailable;

use Illuminate\Http\Request;
use Mail;
class HomeController extends Controller
{
    
    public function mail()
    {
       $name = 'Abhishek';
       Mail::to('krabhishek121995@gmail.com')->send(new SendMailable($name));
       
       return 'Email was sent';
    }
}
