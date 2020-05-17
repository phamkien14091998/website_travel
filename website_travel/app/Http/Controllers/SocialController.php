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
        // return Socialite::driver('google')->redirect();
    }  

    // public function googleLoginUrl()
    // {
    //     dd(response()->json([
    //         'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
    //     ]));
    //     return response()->json([
    //         'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
    //     ]);
    // }

    public function googleLoginCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // dd($googleUser);
        DB::beginTransaction();
        try {
            dd($googleUser->getName());die;
            $socialAccount = users::firstOrNew(
                ['user_id' => $googleUser->getId(), 'social_provider' => 'google'],
                ['user_name' => $googleUser->getName()]
            );
            
            if (!($user = $socialAccount->user)) {
                $user = users::create([
                    'email' => $googleUser->getEmail(),
                    'user_name' => $googleUser->getName(),
                ]);
                $socialAccount->fill(['user_id' => $user->id])->save();
            }

            // Manually login user
            Auth::setUser($user);

            DB::commit();

            return response()->json([
                'user' => new UserResource($user),
                'google_user' => $googleUser,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);

            throw $e;
        }
    
    }

}
