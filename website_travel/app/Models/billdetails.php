<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class billdetails extends Model
{
    //
    protected $table="bill_details";
    
    protected $primaryKey = 'bill_detail_id';
    public $timestamps = false;
    protected $guarded = [];

}

?>