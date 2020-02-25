<?php

namespace App\Http\Controllers;

use App\Leave;
use Illuminate\Http\Request;
use Validator;
use Mail;
use App\User;
use DB;
use App\Mail\SendMailable;
use Illuminate\Support\Collection;
use FastExcel;
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

        return response()->json($leaves->load('user'),201);

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
           "status" => "required|max:20,string",
          "start_date" => "required|date_format:d/m/Y",
          "end_date" => "required|date_format:d/m/Y",
          "reason" =>   "required|max:50,string",
          "type_of_leaves" => "required|",
          "user_id" => "required|integer"

        ]);
        if($validation->fails())
        {
            $errors = $validation->errors();
            return response()->json($errors,201);
        }
        //dd($request->all());

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
    public function update(Request $request, $id)
    {
        /*$leave = Leave::find($id);
       if($leave)
     {

        $validation = Validator::make($request->all(),[
            "status" => "required|max:20,string",
            //"start_date" => "required|date_format:d/m/Y",
            //"end_date" => "required|date_format:d/m/Y",
            //"reason" =>   "required|max:50,string",
           // "type_of_leave" => "required|",
            //"user_id" => "required|integer"

         
        ]);
        $leave->update($request->all());
        $user = User::where('is_admin',true)->first();
        Mail::to($user->email)->send(new SendMailable($leave));
          return response()->json($leave,200);
      }*/

      //return response()->json(['leave'=>'not found']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        
    }

    public function changeStatus(Request $request, $id)
    {
         $leave = Leave::find($id);
       if($leave)
     {

        $validation = Validator::make($request->all(),[
            "status" => "required|max:20,string",   
        ]);
        $leave->update($request->all());
        $user = User::where('is_admin',true)->first();
        Mail::to($user->email)->send(new SendMailable($leave));
            return response()->json($leave,200);
       

      
      }

    }


    public function balance(Request $request, $id)
    {

     $user = User::find($id);
      if($user) {
        $leaves = $user->leaves->where('status','approved');
        $sick_balance = 0;
        $casual_balance = 0;
        $privilage_balance = 0;
        $res = collect(); 
        foreach ($leaves as $leave) 
        {
                if($leave->type_of_leaves  == 'sick') {
                    $sick_balance = $sick_balance +1;
                }
                else if($leave->type_of_leaves == 'casual') {
                    $casual_balance = $casual_balance + 1;
                }
                else if($leave->type_of_leaves == 'privilage')
                {
                    $privilage_balance = $privilage_balance+1;
                }
        }
           $balance_casual_leave = $user->allotted_casual_leave-$casual_balance;
           $balance_sick_leave = $user->allotted_sick_leave-$sick_balance;
           $balance_privilage_leave = $user->allotted_privilage_leave-$privilage_balance;
           $rest  = array();
           $rest['balance_casual_leave'] = $balance_casual_leave;
           $rest['balance_sick_leave'] = $balance_sick_leave;
           $rest['balance_privilage_leave'] = $balance_privilage_leave;
           $res->push($user); 
          $res->push($rest);
          return response()->json($res,201);

        }
    
    }
    public function exportExcel($id) 
    {

      $user = User::find($id);
      if($user) {
        $leaves = $user->leaves->where('status','approved');
        $sick_balance = 0;
        $casual_balance = 0;
        $privilage_balance = 0; 
        foreach ($leaves as $leave) 
        {
                if($leave->type_of_leaves  == 'sick') {
                    $sick_balance = $sick_balance +1;
                }
                else if($leave->type_of_leaves == 'casual') {
                    $casual_balance = $casual_balance + 1;
                }
                else if($leave->type_of_leaves == 'privilage')
                {
                    $privilage_balance = $privilage_balance+1;
                }
        }

           $balance_casual_leave = $user->allotted_casual_leave-$casual_balance;
           $balance_sick_leave = $user->allotted_sick_leave-$sick_balance;
           $balance_privilage_leave = $user->allotted_privilage_leave-$privilage_balance;
        $res = collect();
        $rest=array();
        foreach ($leaves as $leave) 
        {

           $rest['Name'] = $leave->user && $leave->user->first_name ?  $leave->user->first_name." ".($leave->user->last_name? $leave->user->last_name :"" ):"";
           $rest['Email'] = $leave->user->email;
           $rest['Mobile_No'] = $leave->user->mobile_no;
           $rest['Allotted_Casual_Leave'] = $leave->user->allotted_casual_leave;
           $rest['Allotted_Sick_Leave'] = $leave->user->allotted_sick_leave;
           $rest['Allotted_Privilage_Leave'] = $leave->user->allotted_privilage_leave;
           $rest['Approved_Casual_Leave'] = $casual_balance;
           $rest['Approved_Sick_Leave'] = $sick_balance;
           $rest['Approve_Privilage_Leave'] = $privilage_balance;
           $rest['Balance_Casual_Leave'] = $balance_casual_leave;
           $rest['Balance_Sick_Leave'] = $balance_sick_leave;
           $rest['Balance_privilage_Leave'] = $balance_privilage_leave; 
            $res->push($rest);
        }


        $fileName = 'leaves.'.'xls';
        FastExcel::data($res)->export($fileName);
        return url($fileName);
         
          // return response()->json($res,201);

        }

    }
    public function exportExcelAllUser()
    {
        $users = User::get();
        if($users)
        {
            $res = collect();
            foreach ($users as $user) 
             {
                    $leaves = $user->leaves->where('status','approved');
                    $sick_balance = 0;
                    $casual_balance = 0;
                    $privilage_balance = 0; 
                    foreach ($leaves as $leave) 
                    {
                            if($leave->type_of_leaves  == 'sick') {
                                $sick_balance = $sick_balance +1;
                            }
                            else if($leave->type_of_leaves == 'casual') {
                                $casual_balance = $casual_balance + 1;
                            }
                            else if($leave->type_of_leaves == 'privilage')
                            {
                                $privilage_balance = $privilage_balance+1;
                            }
                    }

                       $balance_casual_leave = $user->allotted_casual_leave-$casual_balance;
                       $balance_sick_leave = $user->allotted_sick_leave-$sick_balance;
                       $balance_privilage_leave = $user->allotted_privilage_leave-$privilage_balance;
                    $rest=array();
                    foreach ($leaves as $leave) 
                    {

                       $rest['Name'] = $leave->user && $leave->user->first_name ?  $leave->user->first_name." ".($leave->user->last_name? $leave->user->last_name :"" ):"";
                       $rest['Email'] = $leave->user->email;
                       $rest['Mobile_No'] = $leave->user->mobile_no;
                       $rest['Allotted_Casual_Leave'] = $leave->user->allotted_casual_leave;
                       $rest['Allotted_Sick_Leave'] = $leave->user->allotted_sick_leave;
                       $rest['Allotted_Privilage_Leave'] = $leave->user->allotted_privilage_leave;
                       $rest['Approved_Casual_Leave'] = $casual_balance;
                       $rest['Approved_Sick_Leave'] = $sick_balance;
                       $rest['Approve_Privilage_Leave'] = $privilage_balance;
                       $rest['Balance_Casual_Leave'] = $balance_casual_leave;
                       $rest['Balance_Sick_Leave'] = $balance_sick_leave;
                       $rest['Balance_privilage_Leave'] = $balance_privilage_leave; 
                        $res->push($rest);
                    }


                    

                    }
            
             }
             $fileName = 'leaves.'.'xls';
                    FastExcel::data($res)->export($fileName);
                    return url($fileName);
                     
        
        }



     
}



 