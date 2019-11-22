<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Carousel extends Model {
    protected $table = 'carousel';

    protected $fillable = ['title', 'description', 'image'];

    public static function getCarouselImage($id) {
        return DB::select('SELECT * FROM carousel WHERE id=?', array($id))[0];
    }

}