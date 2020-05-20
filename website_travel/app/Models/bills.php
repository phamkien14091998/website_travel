<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\billdetails;
use Illuminate\Support\Facades\Session;

class bills extends Model
{
    //
    protected $table="bills";
    
    protected $primaryKey = 'bill_id';
    public $timestamps = false;
    protected $guarded = [];

    // thanh toán
    public static function payment($dataPayment,$cart){
        $dataPayment['created_at'] = Carbon::now();

        $bill_id = bills::insertGetId($dataPayment);
        $bill_detail_id = 0;
        for($i = 0 ; $i < count($cart) ; $i++){
            $dataBillDetail = [
                'bill_id' => $bill_id,
                'product_id' => $cart[$i]['id'],
                'quantity' => $cart[$i]['qty'],
                'price' => $cart[$i]['price'],
                'created_at' => Carbon::now(),
            ];
            $bill_detail_id = billdetails::insertGetId($dataBillDetail);
        }
        if($bill_id != 0 && $bill_detail_id != 0){
            Session::forget('cart.name');
            return true;
        }
        return false;
        
    }

}
?>