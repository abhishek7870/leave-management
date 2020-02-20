<?php

namespace App\Http\Controllers;

use App\Leave;
use Illuminate\Http\Request;
use Validator;
use Mail;
use App\User;
use App\Mail\SendMailable;
class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaves = Leave::all();

        return response()->json($leaves->load('users'),201);

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
        $validation = Validator::make($request->all(),[
          
          "start_date" => "required|date_format:d/m/Y",
          "end_date" => "required|date_format:d/m/Y",
          "reason" =>   "required|max:50,string",
          "type_of_leave" => "required|",
          "user_id" => "required|integer"

        ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            return response()->json($errors,201);
        }

        $leave = Leave::create($request->all());

       $user = User::where('is_admin',true)->first();
       Mail::to($user->email)->send(new SendMailable($leave));
         return response()->json($leave,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
