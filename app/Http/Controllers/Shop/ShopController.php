<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller {

    public function index() {
        $categories = DB::select('SELECT * FROM categories');
        return view('shop.index', ['categories' => $categories]);
    }

    public function openCategory($id = null) {
        if(isset($id)) {
            $products = Product::getProductWhereCategory($id);
            $category_name = Category::getCategoryName($id);
            return view('shop.category_products', ['products' => $products, 'category_name' => $category_name]);
        }
    }

    public function openProduct($id = null) {
        if(isset($id)) {
            $product = Product::getProduct($id);
            return view('shop.product_page', ['product' => $product]);
        }
    }

}