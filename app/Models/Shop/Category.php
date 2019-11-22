<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model {

    protected $table = 'categories';

    protected $fillable = ['category'];

    public static function getCategory($id) {
        return DB::select('SELECT * FROM categories WHERE id=?', array($id))[0];
    }

    public static function getCategoryName($id) {
        return DB::select('SELECT category FROM categories WHERE id=?', array($id))[0]->category;
    }

    public static function getAllCategories() {
        return DB::select('SELECT * FROM categories');
    }

}