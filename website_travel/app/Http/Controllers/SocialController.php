<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Socialite;
// use Session;
use URL;

use Laravel\Socialite\Facades\Socialite;
use App\Models\users;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    /**
     * Chuyển hướng người dùng sang OAuth Provider.
     *
     * @return Response
     */
    public function googleLoginUrl()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }  
    //xử lý
    public function googleLoginCallback()
    {
        try { 
            $user = Socialite::driver('google')->stateless()->user();
            
            $finduser = users::where('email',$user->email)->first();  // tim xem email có trong db chưa
            
            if($finduser){ // nếu có 
                $token =users::loginGoogle($finduser);
               
                // $url = 'http://localhost:4200/google-login?token='.$token;
                $url = 'https://app-deploy-a1b74.web.app/google-login?token='.$token;
                return redirect($url); 

            }else{
                $user_name= $user->name; 
                $email = $user->email;
              
                $newUser = users::createUserGoogle($user_name,$email);
                
                $token =users::loginGoogle($newUser);
               
                // $url = 'http://localhost:4200/google-login?token='.$token;
                $url = 'https://app-deploy-a1b74.web.app/google-login?token='.$token;
                return redirect($url); 
            }

        } catch (Exception $e) { 
            return redirect('/auth/google/url');
            // return redirect('http://localhost:4200/login');
        }
      
    
    }

}