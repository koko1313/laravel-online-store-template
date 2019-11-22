<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class ProfileController extends Controller {

    public function index() {
        return view('user_system.profile');
    }

    public function update(Request $req) {
        if(Input::has('edit_name')) {
            $this->Validate($req, [
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

            if(User::where('id', $req->id)->update(['first_name' => $req->first_name, 'last_name' => $req->last_name])) {
                return redirect()->back()->with('success', 'Името беше редактирао успешно');
            }

            return redirect()->back()->with('error', 'Неуспешно редактиране на име. Моля опирайте отново');
        } else

        if(Input::has('edit_email')) {
            $this->validate($req, [
                'email' => 'required|email'
            ]);

            if(User::where('email', $req->email)->count() > 0) {
                return redirect()->back()->with('error', 'Този email адрес е зает от друг потребител!');
            }

            if(User::where('id', $req->id)->update(['email' => $req->email])) {
                return redirect()->back()->with('success', 'E-mail-а беше редактиран успешно');
            }

            return redirect()->back()->with('error', 'Неуспешно редактиране на e-mail. Моля опирайте отново');
        } else

        if(Input::has('edit_phone')) {
            $this->validate($req, [
                'phone' => 'required|max:10|min:10'
            ]);

            if(User::where('id', $req->id)->update(['phone' => $req->phone])) {
                return redirect()->back()->with('success', 'Телефона беше редактиран успешно');
            }

            return redirect()->back()->with('error', 'Неуспешно редактиране на телефон. Моля опирайте отново');
        } else

        if(Input::has('edit_password')) {
            $this->validate($req, [
                'old_password' => 'required',
                'password' => 'required|min:6',
                'password_confirm' => 'required|same:password'
            ]);

            $password_from_db = User::getUser($req->id)->password;

            if(Hash::check($req->old_password, $password_from_db) || $req->old_password == $password_from_db && $password_from_db == 'password') {
                $password = bcrypt($req->password);
                if(User::where('id', $req->id)->update(['password' => $password])) {
                    return redirect()->back()->with('success', 'Паролата беше сменена успешно');
                } else {
                    return redirect()->back()->with('error', 'Проблем при смяната на парола. Моля опитайте отново');
                }
            } else {
                return redirect()->back()->with('error', 'Невалидна стара парола');
            }
        }
    }

}