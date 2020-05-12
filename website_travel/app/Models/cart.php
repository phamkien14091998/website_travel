<?php

// namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

use App\Models\products;
use DB; 

class cart extends Model
{
	//thêm sản phẩm vào giỏ hàng
	public static function add($product_id){
		$product = products::find($product_id);
		$temp = 0;
        if(Session::has('cart')){
            for($i=0 ; $i < count(Session::get('cart.name')) ; $i++){
               if($product_id == Session::get('cart.name')[$i]['product_id']){
                    $temp += 1;
                }
            }
            if($temp == 0) {
                Session::push('cart.name', $product);
            }
        } else {
            Session::put('cart',$product);
            Session::push('cart.name', $product);
		}
		return Session::get('cart.name');
	}

	//get all product for cart
	public static function getAllProductForCart(){
		if(Session::has('cart')){
			return Session::get('cart.name');
		}
		return null;
	}

	//xóa một sản phẩm khỏi giỏ hàng
	public static function deleteProductFromCart($product_id){
		if(Session::has('cart')){
            for($i=0 ; $i < count(Session::get('cart.name')) ; $i++){
               if($product_id == Session::get('cart.name')[$i]['product_id']){
				   unset(Session::get('cart.name')[$i]['product_id']); 
					return Session::get('cart');
                }
            }
        }
		return 'Thất bại';
	}

	//get tổng tiền các sản phẩm trong cart
	public static function getTotalCart(){
		$totalMoney = 0;
		for($i=0 ; $i < count(Session::get('cart.name')) ; $i++){
			if(Session::has('cart') && Session::get('cart.name')[$i]['product_id'] != null) {
				$totalMoney += (int)Session::get('cart.name')[$i]['price'];
			}
		}
		return $totalMoney;
	}
}