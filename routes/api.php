<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::resource('administrations','AdministrationController');

Route::resource('users','UserController');

//Route::resource('balances','BalanceController');

//Route::resource('colleges','CollegeController');

//Route::resource('teachers','TeacherController');

Route::resource('leaves','LeaveController');

Route::patch('/changestatus/{id}','LeaveController@changeStatus');

Route::patch('/balance/{id}','LeaveController@balance');



