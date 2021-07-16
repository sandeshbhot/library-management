<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\User; 
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;


class UserController extends BaseController{
	
	public $successStatus = 200;
    
    //Login
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    //Registration
    public function registeration(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'mobile' => 'required|unique:users',
            'age' => 'required',
            'city' => 'required',
            'gender' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['firstname'] =  $user->firstname;


        return $this->sendResponse($success, 'User registered successfully.');
    }

    //logout
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
        //return response()->json(['success' => $response], $this-> successStatus); 
    } 

    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        //$input['password'] = bcrypt($input['password']);
        $user = User::where('email', '=', $request->email)->update($input);
        $response = 'User Updated Successfully';
        return $this->sendResponse($response, 'User Updated successfully.');
    }
}