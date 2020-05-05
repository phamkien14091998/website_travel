<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    //
    protected $table="users";
    
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [
         'email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

}
