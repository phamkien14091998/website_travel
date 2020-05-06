<?php

namespace App\Http\Controllers;

use App\Models\users;
use App\User;
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

class UserController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'user_name' => 'required|string|max:20', 
            'email' => 'required|string|email|max:40|unique:users',  // email k đc trùng
            'password' => 'required|string|min:5',
        ]);
        if($validator->fails()){ 
            return response()->json($validator->errors()->toJson(),400);
        }
        $users = User::create([
            'user_name'=>$request->get('user_name'),
            'email'=>$request->get('email'),
            // 'password'=>$request->get('password'),
            'password'=>Hash::make($request->get('password')),
            'full_name'=>$request->get('full_name'),
            'avatar'=>$request->get('avatar'),
            'date_of_birth'=>$request->get('date_of_birth'),
            'gender'=>$request->get('gender'),
            'hometown'=>$request->get('hometown'),
            'hobbies'=>$request->get('hobbies'),
        ]);
        $token = JWTAuth::fromUser($users); // tao ra token
        return response()->json(compact('users','token'),201);
    } 
	public function login(Request $request){
        $creadentials = $request->only('email', 'password');
        try{
            $user=User::where(['email'=>$request->input('email')])->first();
            $customClaims = ['user_name' => $user['user_name'],'role' => $user['role'],'user_id' => $user['user_id']];
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
        
        return response()->json(compact('token'));    
    
        //  if (Auth::attempt(['email' => $email, 'password' => $password, 'role' => 1])) { // trả về true /false
        //     // email admin mới được xác thực thành công 
        // }
    }
    public function getAuthenticatedUser(){
        try {
            if(!$user = JWTAuth::parseToken()->authenticate()){
                return response()->json([
                    'user not found' 
                ],404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'token expired'
            ],$e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'token invalid'
            ],$e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'token absent'
            ],$e->getStatusCode());
        }
        return response()->json(compact('users')); // gom thanh array
    }

    // get user 
    public function getUser(){
        try {
            if(!$user = JWTAuth::parseToken()->authenticate()){
                return response()->json([
                    'user not found' 
                ],404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'token expired'
            ],$e->getStatusCode());
        }
        return response()->json(compact('users'));
    }

    public function getUserByUserName(Request $request){
        if($request->user_name){
            $user_name = $request->user_name;
            $data_search = users::getUserByUserName($user_name);
            return  response()->json($data_search,'200');
        }
    }

    public function getUserByUserId(Request $request){
        if($request->user_id){
            $user_id = $request->user_id;
            $data_search = users::getUserByUserId($user_id);
            return  response()->json($data_search,'200');
        }
    }

    public function updateUserById(Request $request)
    {
        if($request->images){
            $image_string= $request->images;
            $image_string=explode(",", $image_string);
            $image_string=join("|",$image_string);
        }
        // update product tên có thể k sửa
        // $validator = Validator::make($request->all(),[
        //     'product_name' => 'required|string|max:40|unique:products', 
        // ]);
        // if($validator->fails()){  
        //     return response()->json('dữ liệu không hợp lệ',500);
        // }
        

        $uploadPath="upload/";
        $filename='';

        $images = array();
        if(isset($_FILES['fileUpload']['name'])){
            for($i=0 ; $i<count($_FILES['fileUpload']['name']);$i++){
                $filename = $uploadPath . date("His-d-m-Y").rand(1,1000) . $_FILES['fileUpload']['name'][$i];
                // thêm dữ liệu vô mảng mới
                array_push($images,$filename);
                // lưu hình
                $d=move_uploaded_file($_FILES['fileUpload']['tmp_name'][$i],$filename);
            } 
        // ghép mảng images thành chuỗi ngăn cách bởi dấu |
            $image_string='';
            $image_string=join("|",$images);
        }
      
        $product_id= $request->product_id;
        $data=[
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'portfolio_id' => $request->portfolio_id,
            'images'=> $image_string,
        ]; 
       
        if($data){  
            $data_product=products::updateProductById($product_id,$data);
            // if($data_product){ 
                return response()->json('Sửa Thành Công',200);
            // }
            // return response()->json('Sửa Thất Bại',400);
        }
       return response()->json('Thiêu dữ liệu truyền vào',500);

    }

}
