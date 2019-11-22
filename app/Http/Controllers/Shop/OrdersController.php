<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order;
use App\Models\Shop\Order_product;

class OrdersController extends Controller {

    public function open() {
        $processing_orders = Order::getAllWhereStatus('processing');
        $finished_orders = Order::getAllWhereStatus('finished');
        return view('shop.manage_orders', ['processing_orders' => $processing_orders, 'finished_orders' => $finished_orders]);
    }

    public function finish_order($id) {
        Order::where('id', $id)->update(['status' => 'finished']);
        return redirect()->back();
    }

    public function restore_order($id) {
        Order::where('id', $id)->update(['status' => 'processing']);
        return redirect()->back();
    }

    public function delete_order($id) {
        Order::where('id', $id)->delete();
        return redirect()->back();
    }

    public function view_order($id) {
        $order = Order::getOrder($id);
        if($order) return view('shop.order_page', ['order' => $order]);
        return redirect(route('manage_orders'));
    }

    public function remove_product($order_id, $product_id) {
        Order_product::where('order_id', $order_id)->where('product_id', $product_id)->delete();
        if(sizeof(Order_product::getProductsByOrderId($order_id)) == 0) {
            Order::where('id', $order_id)->delete();
        }
        return redirect()->back();
    }

}