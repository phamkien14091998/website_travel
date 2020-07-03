<?php

// namespace App;
namespace App\Models;

namespace App\Models;
use DB;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

use App\Models\products;


class cart extends Model
{
	protected $table="session";   
    
	
	//thêm sản phẩm vào giỏ hàng
	public static function add($product_id,$user_id){
		$product = DB::table('products')
		->select('product_id','product_name','images','price')
		->where('product_id',$product_id)->get();

		$data=[
			'product_id'=>$product[0]->product_id,
			'name'=>$product[0]->product_name,
			'qty'=>1,
			'price'=>$product[0]->price,
			'images'=>$product[0]->images,
			'user_id'=>$user_id
		];
		$temp=0;
	
		// get sản phẩm trong bảng mới
		$array_product = DB::table('session')->get();

		if(count($array_product) < 1){ 

			DB::table('session')->insertGetId($data);
		}
		else if(count($array_product) >= 1){
			foreach($array_product as $k => $v){
				// neu có id r
				if($product_id == $array_product[$k]->product_id){
					$temp++;
				}
			}
			if($temp==0){
				DB::table('session')->insertGetId($data);
			}
		}

       return 1;
	}

	//get all product for cart
	public static function getAllProductForCart(){ 
		
		$array_product = DB::table('session')->get();

		if(count($array_product) >= 1){ 
			return $array_product;
		}
		return null;
	}
	//xóa một sản phẩm khỏi giỏ hàng
	public static function deleteProductFromCart($product_id){
		$array_product = DB::table('session')->get();
		$temp=0;

		foreach($array_product as $k => $v){
			// neu có id r
			if($product_id == $array_product[$k]->product_id){
				return DB::table('session')->where('product_id','=',$product_id)
                ->delete();
			}
		}
		return 'null';
	}

	//get tổng tiền các sản phẩm trong cart
	public static function getTotalCart(){
		$array_product = DB::table('session')->get();

		$totalMoney = 0;
		foreach($array_product as $k => $v){
			// neu có id r
			$totalMoney += (int)$array_product[$k]->price * $array_product[$k]->qty;
			
		}
		return $totalMoney;
	}

	//tăng số lượng sản phẩm trong cart
	public static function tangSoLuongSP($id){
		
		$array_product = DB::table('session')->get();

		foreach($array_product as $k => $v){
			if($id == $array_product[$k]->product_id){
				$qty = (int)$array_product[$k]->qty + 1;
				DB::table('session')->where('product_id',$id)
				->update(['qty'=>$qty]); 
			}
			
		}
		return $array_product;
	}

	//giảm số lượng sản phẩm trong cart
	public static function giamSoLuongSP($id){
		$array_product = DB::table('session')->get();

		foreach($array_product as $k => $v){
			if($id == $array_product[$k]->product_id){
				$qty = (int)$array_product[$k]->qty - 1;
				DB::table('session')->where('product_id',$id)
				->update(['qty'=>$qty]); 
			}
			
		}
		return $array_product;
	}

	public static function getSoLuongTonKho(){
		$arr = [];
		if(Session::has('cart')){
			for($i=0 ; $i < count(Session::get('cart.name')) ; $i++){
				$t = Session::get('cart.name');
				$arr[$i] = products::find($t[$i]['id'])['quantity'];
			}
			return $arr;
		} else {
			return null;
		}
	}
}