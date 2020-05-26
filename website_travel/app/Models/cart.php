<?php

// namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

use App\Models\products;


class cart extends Model
{
	//thêm sản phẩm vào giỏ hàng
	public static function add($product_id){
		$product = products::find($product_id);
		$temp = 0;
		
        if(Session::has('cart')){	
            for($i=0 ; $i < count(Session::get('cart.name')) ; $i++){
               if($product_id == Session::get('cart.name')[$i]['id']){
					$temp += 1;
                }
			}
            if($temp == 0) {
                Session::push('cart.name', ['id' => $product_id, 'qty' => 1,'name' => $product->product_name, 'price' => $product->price,'images' => $product->images]);
			}
        } else {
			Session::put('cart',$product);
			Session::push('cart.name', ['id' => $product_id, 'qty' => 1,'name' => $product->product_name, 'price' => $product->price,'images' => $product->images]);
		}
		return count(Session::get('cart.name'));
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
			$product = products::find($product_id);
			$products = Session::pull('cart.name', []); // Second argument is a default value

			$mangId = [];
			for($i=0 ; $i < count($products) ; $i++){
				$mangId[$i] = ($products[$i]['id']);
			}
			if(($key = array_search($product['product_id'], $mangId)) != 1000) {
				array_splice($products,$key,1);
			}
			Session::put('cart.name', $products);
        } else {
			return 'null';
		}
		if(count(Session::get('cart.name')) > 0) {
			return Session::get('cart.name');
		}
		return 'null';
	}

	//get tổng tiền các sản phẩm trong cart
	public static function getTotalCart(){
		$totalMoney = 0;
		if(Session::has('cart')){
			for($i=0 ; $i < count(Session::get('cart.name')) ; $i++){
				if(Session::get('cart.name')[$i]['id'] != null) {
					$totalMoney += (int)Session::get('cart.name')[$i]['price'] * Session::get('cart.name')[$i]['qty'];
				}
			}
		}
		return $totalMoney;
	}

	//tăng số lượng sản phẩm trong cart
	public static function tangSoLuongSP($id){
		$soLuongCon = products::find($id)['quantity'];
		if(Session::has('cart')){
			for($i=0 ; $i < count(Session::get('cart.name')) ; $i++){
				if(Session::get('cart.name')[$i]['id'] == $id) {
					$t = Session::get('cart.name');			
					$t[$i]['qty'] +=1;
					Session::put('cart.name', $t);
					break;
				}
			}
		}
		return Session::get('cart.name');
		//return null;
	}

	//giảm số lượng sản phẩm trong cart
	public static function giamSoLuongSP($id){
		if(Session::has('cart')){
			for($i=0 ; $i < count(Session::get('cart.name')) ; $i++){
				if(Session::get('cart.name')[$i]['id'] == $id) {
					$t = Session::get('cart.name');
					if($t[$i]['qty'] > 1){
						$t[$i]['qty'] -=1;
						Session::put('cart.name', $t);
					}
					break;
				}
			}
		}
		return Session::get('cart.name');
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