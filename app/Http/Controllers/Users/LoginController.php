<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller {

    public function form() {
        return view('user_system.login');
    }

    public function login(Request $req) {
        $this->validate($req,[
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $req->email)->first();

        if(!$user) {
            return back()->with('error','Невалиден e-mail или парола!')->withInput(Input::all());
        }

        if(Hash::check($req->password, $user->password) || $user->password == $req->password && $user->password == 'password') {
            Auth::login($user);

            return redirect()->route('index');
        }

        return back()->with('error','Невалиден e-mail или парола!')->withInput(Input::all());
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('index');
    }
}