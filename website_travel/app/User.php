<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table="users";
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $guarded = [];

    /**
     * Điền đầy đủ các trường khi truyền dữ liệu lên
     *
     * @var array
     */
    protected $fillable = [ 
        'user_name',
        'email',  
        'password',
        'full_name',
        'avatar',
        'date_of_birth',
        'gender',
        'hometown',
        'hobbies',
        ''
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }


}
