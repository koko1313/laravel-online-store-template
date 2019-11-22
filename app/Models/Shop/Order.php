<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model {

    protected $table = 'orders';

    protected $fillable = ['user_id', 'status'];

    public static function getAllWhereStatus($status) {
        return DB::select('SELECT * FROM orders_view WHERE status=?', array($status));
    }

    public static function getOrder($id) {
        $order = DB::select('SELECT * FROM orders_view WHERE order_id=?', array($id));

        if($order) {
            $order = $order[0];
            $order->product_id_list = explode(',', $order->product_id_list);
            $order->product_title_list = explode(',', $order->product_title_list);
            $order->quanity_list = explode(',', $order->quanity_list);
            $order->price_list = explode(',', $order->price_list);
            $order->total_price_list = explode(',', $order->total_price_list);
            return $order;
        }
    }

}