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
                'portfolio_name',
                'product_name',
                'price', 
                'description',
                'quantity',
                'images',
                'flag'
            )
            ->get(); 
    }
   



}
