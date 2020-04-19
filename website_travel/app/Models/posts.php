<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    //
    protected $table="posts";
    
    protected $primaryKey = 'post_id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [ 
        'title',
        'location', 
        'duration',
        'uptime',
        'fare',
        'main_image',
        'flag',

    ];

}
