<?php

namespace App\Http\Controllers;

use App\User1;
use Illuminate\Http\Request;
use Validator;
class User1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User1::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(),[
         
             "name" => "required|max:20",
             "mobile_no" => "required|unique:user1s,mobile_no",
             "casual_leaves" => "required:max:15",
             "sick_leaves" => "required:max:15",
             "study_leaves" => "required:max:15",
             "maternity_leaves" => "required:max:15",
             "email" => "required|unique:user1s,email",
             "request" => "required"
        ]);
        if($validations->fails())
        {
            $errors = $validations->errors();
            return response()->json($errors,201);
        }
        $user1s = User1::create($request->all());
        return response()->json($user1s,200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User1  $user1
     * @return \Illuminate\Http\Response
     */
    public function show(User1 $user1)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User1  $user1
     * @return \Illuminate\Http\Response
     */
    public function edit(User1 $user1)
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
    public function update(Request $request, User1 $user1)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User1  $user1
     * @return \Illuminate\Http\Response
     */
    public function destroy(User1 $user1)
    {
        //
    }
}
