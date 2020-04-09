<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;

class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'user_name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],

        ]);

        if($validator->fails()){ 
            return response()->json($validator->errors()->toJson(),400);
        }

        
        $users = User::create([
            'user_name'=>$request->get('user_name'),
            'email'=>$request->get('email'),
            'password'=>$request->get('password'),
            //'password'=>Hash::make($request->json()->get('password')),
            'full_name'=>$request->get('full_name'),
            'avatar'=>$request->get('avatar'),
            'date_of_birth'=>$request->get('date_of_birth'),
            'gender'=>$request->get('gender'),
            'hometown'=>$request->get('hometown'),
            'hobbies'=>$request->get('hobbies'),
        ]);
       
        $token = JWTAuth::fromUser($users);
        return response()->json(compact('users','token'),201);

    } 

	public function login(Request $request){
        $creadentials = $request->json()->all();
        
        try{
            if(! $token = JWTAuth::attempt($creadentials)){
                return response()->json([
                    'error'=>'invalid credentials'
                ],400);
            }

        }catch(JWTException $e){
            return response()->json([
                'error'=>'could not create token'
            ]);
        }
    	 return response()->json(compact('token'));        
    }

    public function getAuthenticatedUser(){
        try {
            if(!$user = JWTAuth::parseToken()->authenticate()){
                return response()->json([
                    'user not found' 
                ],404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'token expired'
            ],$e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'token invalid'
            ],$e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'token absent'
            ],$e->getStatusCode());
        }
        return response()->json(compact('users')); // gom thanh array

    }

}
