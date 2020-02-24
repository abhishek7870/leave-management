<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Hash;
class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users->load('leaves'),201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        return response()->json($users->load('leaves'),201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//($request->all());
        $validations = Validator::make($request->all(),[
         
             "first_name" => "required|max:20",
             "last_name" => "required|max:20",
             //"is_admin" => "required",
             "mobile_no" => "required|unique:users,mobile_no",
             "allotted_casual_leave" => "required:max:15",
             "allotted_sick_leave" => "required:max:15",
             "allotted_privilage_leave" => "required:max:15",
             "email" => "required|unique:users,email",
             "allowted_leave_without_pay" => "required",
             "password" => "required|max:10"
        ]);
        if($validations->fails())
        {
            $errors = $validations->errors();
            return response()->json($errors,201);
        }
      //  dd($request->all());
    
        $request['password'] = Hash::make($request['password']);
        $users = User::create($request->all());
        return response()->json($users,200);
    }  

    /**
     * Display the specified resource.
     *
     * @param  \App\User1  $user1
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User1  $user1
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User1  $user1
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User1  $user1
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
