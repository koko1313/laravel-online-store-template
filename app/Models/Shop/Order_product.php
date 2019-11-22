<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order_product extends Model {

    protected $table = 'order_products';

    protected $fillable = ['order_id', 'product_id', 'price', 'quanity'];

    public static function getProductsByOrderId($id) {
        return DB::select('SELECT * FROM order_products WHERE order_id=?', array($id));
    }

}