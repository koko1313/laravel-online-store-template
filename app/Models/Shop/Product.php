<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model {

    protected $table = 'products';

    protected $fillable = ['id', 'title', 'price', 'description', 'category_id', 'main_image', 'images'];

    public static function getProduct($id) {
        $product = DB::select('SELECT * FROM products_view WHERE id=?', array($id));
        if($product) {
            $product = $product[0];
            $product->images = explode(';', $product->images); // правим изображенията в масив, защото са в низ в базата
            $product->images = array_slice($product->images, 0, sizeof($product->images)-1); // режем последния елемент, защото е празен
            return $product;
        }
    }

    public static function getProductWhereCategory($id) {
        return DB::table('products_view')->where('category_id', '=', $id)->paginate(10);
    }

    public static function getProductMainImage($id) {
        return DB::select('SELECT main_image FROM products WHERE id=?', array($id))[0]->main_image;
    }

    public static function getProductImages($id) {
        return DB::select('SELECT images FROM products WHERE id=?', array($id))[0]->images;
    }

}