<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\posts;

class PostController extends Controller
{
    //get List Post
    public function getListPost(){

        $data= posts::getListPost();
        if($data){  
            return response()->json($data,200);
        }
    }

    // get detail post by id
    public function getDetailPost(Request $request){
        $post_id = $request->post_id;

        $data = posts::getDetailPost($post_id);
        return response()->json($data,'200');
    }

}