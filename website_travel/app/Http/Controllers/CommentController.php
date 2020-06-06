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
        $data_comment = $request->all();
        $user_id= $request->user_id;

        $data=comments::createCommentByPostId($user_id,$data_comment);

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

}
