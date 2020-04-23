<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class products extends Model
{
    //
    protected $table="products";
    
    protected $primaryKey = 'product_id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = [ 
        'product_name',
        'price', 
        'description',
        'quantity',
        'portfolio_id',
        'images',

    ];
    // create product
    public static function createProduct($data){

        $data['created_at'] = Carbon::now();
        return  self::insertGetId($data);
    }
    // get list portfilio (danh sách thể loại)
    public static function getListPortfolio(){

        return DB::table('products_portfolio')
                ->get();
    }
    //get list product 
    public static function getListProduct(){

        return DB::table('products')
            ->leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
            ->select(
                'product_id',
                'portfolio_name',
                'product_name',
                'price', 
                'description',
                'quantity',
                'images'
            )
            ->get(); 
    }
   // search product by product_name
   public static function searchProductByname($product_name){
    $condition ='';
    // if(isset($product_name) && $product_name !=''){
        $condition.="product_name like '%{$product_name}%'";
    // } 
    $data_product = self::whereRaw('('.$condition.')')
        ->leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
        ->orderBy('product_id', 'ASC')
        ->select(
            'product_id',
            'portfolio_name',
            'product_name',
            'price', 
            'description',
            'quantity',
            'images'
        )
        ->get();
    
    return $data_product;
   }
   // search all product of product_portfolio_id
   public static function searchProductByportfolioByid($portfolio_id){
    $data_product = self::leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
    ->where('products.portfolio_id','=',$portfolio_id)
    ->orderBy('product_id', 'ASC')
    ->select(
        'product_id',
        'portfolio_name',
        'product_name',
        'price', 
        'description',
        'quantity',
        'images'
    )
    ->get();

    return $data_product;
   }
   // lấy ra sản phẩm có product_name và portfolio_id
   public static function searchProductByProNameAndPortId($product_name,$portfolio_id){
    $condition ='';
    if(isset($product_name) && isset($portfolio_id)){ 
        $condition.="product_name like '%{$product_name}%' and products.portfolio_id = '$portfolio_id'";
    }
    $data_product = self::leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
        ->whereRaw('('.$condition.')')
        ->orderBy('product_id', 'ASC')
        ->select(
            'product_id',
            'portfolio_name',
            'product_name',
            'price', 
            'description',
            'quantity',
            'images'
        )
        ->get();
    
    return $data_product;
   }

   // get detail product by id
   public static function getDetailProduct($product_id){
    $data_product = self::where('product_id','=',$product_id)
    ->leftJoin('products_portfolio','products_portfolio.portfolio_id','=','products.portfolio_id')
    ->select(
        'product_id',
        'portfolio_name',
        'product_name',
        'price', 
        'description',
        'quantity',
        'images'
    )
    ->first();

    return $data_product;
   }



}
