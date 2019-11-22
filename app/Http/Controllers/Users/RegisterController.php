<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RegisterController extends Controller {

    public function form() {
        return view('user_system.register');
    }

    public  function register(Request $req) {
        $this->validate($req, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password'
        ]);

        if(User::where('email', $req->email)->count() > 0) {
            return redirect()->back()->with('error', 'Този email адрес е зает от друг потребител!')->withInput(Input::all());
        }

        $user = new User();
        $user->first_name = $req->first_name;
        $user->last_name = $req->last_name;
        $user->phone = $req->phone;
        $user->email = $req->email;
        $user->address = $req->address;
        $user->password = bcrypt($req->password);
        $user->role_id = 2;

        if($user->save()) {
            return back()->with("success", "Регистрирахте се успешно! Сега можете да влезете.");
        }

        return back()->with('error', 'Регистрацията не беше успешна! Моля опитайте отново.');
    }

}