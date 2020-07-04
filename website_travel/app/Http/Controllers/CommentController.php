<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\comments;

class CommentController extends Controller
{
    //
    public function getAllCommentByPostId(Request $request){
        $post_id = $request->post_id;

        $data = comments::getAllCommentByPostId($post_id);
        
        if($data){ 
            return response()->json($data,200);
        }
        return response()->json('Thất Bại',400);

    }
    public function createCommentByPostId(Request $request){
        $data_comment = [
            'content' => $request->content,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id
        ] ;
        $user_id_create = $request->user_id_create;

        $user_id= $request->user_id;

        $data=comments::createCommentByPostId($user_id,$data_comment,$user_id_create);

        if($data){ 
            return response()->json($data,200);
        }
        return response()->json('Thất Bại',400);
    }
    // xoa comment by comment_id
    public function deleteComment(Request $request){
        $comment_id = $request->comment_id;
        
        $data = comments::deleteComment($comment_id);
        if($data){
            return response()->json('xóa thành công comment',200);
        }else{
            return response()->json('xóa thất bại comment',500);
         }
 
    }
    // update Comment by id
    public function updateCommentByid(Request $request){
        $comment_id= $request->comment_id;
        $content= $request->content;
        $post_id= $request->post_id;
        
        $data = comments::updateCommentByid($comment_id,$content,$post_id);
        
        return  response()->json($data,200);
    }
    // create comment by trip
    public function createCommentByTripId(Request $request){
        $data_comment = $request->all();
        $user_id= $request->user_id;

        $data=comments::createCommentByTripId($user_id,$data_comment);

        if($data){ 
            return response()->json($data,200);
        }
        return response()->json('Thất Bại',400);
    }
    // get all cmt cua lich trinh
    public function getAllCommentByTripId(Request $request){
        $trip_id = $request->trip_id;

        $data = comments::getAllCommentByTripId($trip_id);
        
        if($data){ 
            return response()->json($data,200);
        }
        return response()->json('Thất Bại',400);

    }
    // update cmt by trip_id
    public function updateCommentByidTrip(Request $request){
        $comment_id= $request->comment_id;
        $content= $request->content;
        $trip_id= $request->trip_id;
        
        $data = comments::updateCommentByidTrip($comment_id,$content,$trip_id);
        
        return  response()->json($data,200);
    }
    // get usser by posst_id
    public function getUserByPostId(Request $request){
        $post_id= $request->post_id;
        
        $data = comments::getUserByPostId($post_id);
        
        return  response()->json($data,200);
    }
    

}
