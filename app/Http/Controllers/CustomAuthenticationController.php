<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Validator;
class CustomAuthenticationController extends Controller
{
    public function signIn(Request $request) {
		$validation = Validator::make($request->all(), [
		'email' => 'required',
		'password' => 'required',
		]);
		if ($validation->fails()) {
		$errors = $validation->errors();
		return response()->json($errors, 400);
       }
			$user = User::authenticateUser($request['email'], $request['password']);
			// dd($user);
			if ($user) {
			$customClaims = ['model_type' => 'users'];
			$token = JWTAuth::fromUser($user);
			JWTAuth::setToken($token);
			$data['token'] = 'Bearer ' . $token;
			            $data['user'] = $user->load('permissions');
			return response()->json($data, 200);
			} else {
			return response()->json(['error' => 'Unauthorized'], 401);
			}
}
public function logout(Request $request) {
JWTAuth::invalidate(JWTAuth::getToken());
return response()->json(['true'], 200);
}

}
