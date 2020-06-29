<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;



class users extends Authenticatable implements JWTSubject
{
    use Notifiable;
    //
    protected $table="users";
    
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [  // phải điền đầ đủ những trường cần thêm
         'email','user_name','password','avatar'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }

    // get user by user name
    public static function getUserByUserName($user_name){
        
        $data = self::where('user_name',$user_name)
            ->select(
                'user_id',
                'user_name', 
                'email',
                'password',
                'full_name',
                'avatar',
                'date_of_birth',
                'gender',
                'hometown',
                'hobbies',
                'created_at',
                'updated_at'
            )
            ->first();
        return $data;
        }

    // get user by user name
    public static function getUserByUserId($user_id){
        
        $data = self::where('user_id',$user_id)
            ->select(
                'user_id',
                'user_name', 
                'email',
                'password',
                'full_name',
                'avatar',
                'date_of_birth',
                'gender',
                'hometown',
                'hobbies',
                'created_at',
                'updated_at',
                'phone_number',
                'address'
            )
            ->first();
        return $data;
        }

     // update user by id
     public static function updateUserById($user_id,$data){

        return self::where('user_id', $user_id)
            ->update($data);
    }

    // ham create user by google
    public static function createUserGoogle($user_name,$email){

        $users = self::create([
            'email'=>$email,
            'user_name'=>$user_name,
            'password' => Hash::make('12345'),
            'avatar'=>'upload-avatar/img_user.PNG',
        ]);
       
        $token = JWTAuth::fromUser($users); // tao ra token
        return self::where('email',$email)->first();
        // response()->json(compact('users','token'),201);
    } 
  
    // log in google
    public static function loginGoogle($newUser){ 
        $creadentials = [
            'email'=> $newUser->email,
            'password' => '12345'
        ];
       
        try{
            $user=self::where(['email'=>$newUser->email])->first();
           
            $customClaims = 
            [
            'user_name' => $user->user_name,
            'role' => $user->role,
            'user_id' => $user->user_id,
            'email' => $user->email,
            'avatar' => $user->avatar
            ];
            
            // giờ chế lại
            $token = JWTAuth::claims($customClaims)->attempt($creadentials);
            if(! $token ){  //  khi mã hóa password mới dùng hàm này
               
                return response()->json([ // nó k vô đây nha , tk đúng nên xuống dưới nó tạo token 
                    'error'=>'invalid credentials'
                ],400);
            }
        }catch(JWTException $e){  
            return response()->json([ 
                'error'=>'could not create token'
            ],500);
        }  
        return $token;
        // response()->json(compact('token'));    
    }



}