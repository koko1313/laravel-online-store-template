<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model {

    protected $table = 'cart';

    protected $fillable = ['user_id', 'product_id', 'product_title', 'quanity'];

    public static function getCartByUserId($id) {
        $cart = DB::select('SELECT * FROM cart_view WHERE user_id=?', array($id));
        if($cart) {
            $cart = $cart[0];
            $cart->product_id_list = explode(',', $cart->product_id_list);
            $cart->product_title_list = explode(',', $cart->product_title_list);
            $cart->product_price_list = explode(',', $cart->product_price_list);
            $cart->product_quanity_list = explode(',', $cart->product_quanity_list);
            $cart->product_total_price_list = explode(',', $cart->product_total_price_list);
            return $cart;
        }
    }

    public static function getProductFromCart($product_id, $user_id) {
        $product = DB::select('SELECT * FROM cart WHERE user_id=? AND product_id=?', array($user_id, $product_id));
        if($product) return $product[0];
    }

    public static function getQuanityOfProduct($product_id, $user_id) {
        return DB::select('SELECT quanity FROM cart WHERE product_id=? AND user_id=?', array($product_id, $user_id))[0]->quanity;
    }

}