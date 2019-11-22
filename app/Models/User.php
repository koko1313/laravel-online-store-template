<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable {
    protected $table = 'users';

    protected $fillable = ['email', 'first_name', 'last_name', 'phone', 'password', 'address', 'role_id'];

    public static function getUser($id) {
        return DB::select('SELECT * FROM users_view WHERE id=?', array($id))[0];
    }
}