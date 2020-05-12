<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class SocialController extends Controller
{
    //
    public function getInfoFacebook($social){
        return Socialite::driver($social)->redirect();
    }
    public function checkInfoFacebook($social){
        $info = Socialite::driver($social)->user();
        

    }


}
