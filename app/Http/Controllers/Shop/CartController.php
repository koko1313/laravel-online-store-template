<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\Shop\Order_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller {

    public function open() {
        $user_id = Auth::user()->id;
        $cart = Cart::getCartByUserId($user_id);
        return view('shop.cart', ['cart' => $cart]);
    }

    public function add(Request $req) {
        $user_id = Auth::user()->id;
        $product_id = $req->product_id;
        $quanity = $req->quanity;

        $cart = Cart::getCartByUserId($user_id);
        // ако има количка за този потребител
        if($cart) {
            $product = Cart::getProductFromCart($product_id, $user_id);
            // ако продукта вече е в количката
            if($product) {
                $quanity_in_cart = Cart::getQuanityOfProduct($product->product_id, $user_id);

                // ако е извикано от количката, за промяна на количеството
                if(array_key_exists('change_quanity', $req->all())) {
                    Cart::where('user_id', $user_id)->where('product_id', $product_id)->update(['quanity' => $quanity]);
                    Order_product::where('order_id', $req->order_id)->where('product_id', $product_id)->update(['quanity' => $quanity]); // ако е извикано от страницата за оправление на поръчките
                    return redirect()->back();
                }

                if(Cart::where('user_id', $user_id)->where('product_id', $product_id)->update(['quanity' => $quanity_in_cart + $quanity])) {
                    return redirect()->back()->with('success', 'Продукта беше добавен още веднъж в количката.');
                }

                return redirect()->back()->with('error', 'Продукта не беше добавен в количката. Опитайте отново.');
            }
        }

        $newCart = new Cart();
        $newCart->user_id = $user_id;
        $newCart->product_id = $product_id;
        $newCart->quanity = $quanity;
        if($newCart->save()) {
            return redirect()->back()->with('success', 'Продукта беше добавен в количката.');
        }

        return redirect()->back()->with('error', 'Продукта не беше добавен в количката. Опитайте отново.');
    }

    public function remove($id) {
        Cart::where('user_id', Auth::user()->id)->where('product_id', $id)->delete();
        return redirect()->back();
    }

    public function make_order() {
        $user_id = Auth::user()->id;
        $cart = Cart::getCartByUserId($user_id);
        return view('shop.make_order', ['cart' => $cart]);
    }

    public function finalize_order() {
        $user_id = Auth::user()->id;

        $order = new Order();
        $order->user_id = $user_id;
        $order->status = 'processing';
        $order->save();

        $cart = Cart::getCartByUserId($user_id);

        for($i=0; $i<sizeof($cart->product_id_list); $i++) {
            $order_product = new Order_product();
            $order_product->order_id = $order->id;
            $order_product->product_id = $cart->product_id_list[$i];
            $order_product->product_title = $cart->product_title_list[$i];
            $order_product->price = $cart->product_price_list[$i];
            $order_product->quanity = $cart->product_quanity_list[$i];
            $order_product->save();
        }

        if($order && $order_product) {
            if(Cart::where('user_id', $user_id)->delete()) {
                return redirect(route('cart'))->with('success', 'Поръчката беше направена успешно.');
            }

            Order::where('id', $order->id)->delete();
            Order_product::where('id', $order_product->id)->delete();
        }

        return redirect(route('cart'))->with('error', 'Поръчката не беше направена успешно. Опитайте отново.');
    }

}