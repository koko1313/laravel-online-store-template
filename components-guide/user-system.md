# User system

1. In **config/auth.php** set up user model: 

```php
'model' => App\Models\User::class,
```

2. **Model**: *app/Models/User.php*

```php
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
```

3. **View**:

3.1. *user_system/login.blade.php*

```html
@extends('layout.layout')

@section('title')
    Вход
@endsection

@section('content')

<div class="container">
    <h1>Вход</h1>

    @include('messages')

    <form method="POST">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control" type="email" name="email" id="email" value="{{old('email')}}">
        </div>

        <div class="form-group">
            <label for="password">Парола</label>
            <input class="form-control" type="password" name="password" id="password">
        </div>

        {{csrf_field()}}

        <button class="btn btn-primary form-control" type="submit" name="login">Вход</button>
    </form>

</div>

@endsection
```

3.2. *user_system/register.blade.php*

```html
@extends('layout.layout')

@section('title')
    Регистрация
@endsection

@section('content')

    <div class="container">
        <h1>Регистрация</h1>

        @include('messages')

        <form method="POST">

            <div class="form-group">
                <label for="first_name">Име<font color="red">*</font></label>
                <input class="form-control" type="text" name="first_name" id="first_name" value="{{old('first_name')}}">
            </div>

            <div class="form-group">
                <label for="last_name">Фамилия<font color="red">*</font></label>
                <input class="form-control" type="text" name="last_name" id="last_name" value="{{old('last_name')}}">
            </div>

            <div class="form-group">
                <label for="phone">Телефон<font color="red">*</font></label>
                <input class="form-control" type="number" name="phone" id="phone" value="{{old('phone')}}">
            </div>

            <div class="form-group">
                <label for="email">E-mail<font color="red">*</font></label>
                <input class="form-control" type="email" name="email" id="email" value="{{old('email')}}">
            </div>

            <div class="form-group">
                <label for="address">Адрес</label>
                <textarea class="form-control" id="address" name="address" placeholder="Населено място, адрес, ...">{{old('address')}}</textarea>
                <small id="emailHelp" class="form-text text-muted">Може да бъде попълнен и после.</small>
            </div>

            <div class="form-group">
                <label for="password">Парола<font color="red">*</font></label>
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div class="form-group">
                <label for="password_confirm">Повторете парола<font color="red">*</font></label>
                <input class="form-control" type="password" name="password_confirm" id="password_confirm">
            </div>

            {{csrf_field()}}

            <button class="btn btn-primary form-control" type="submit" name="register">Регистрация</button>

        </form>

    </div>

@endsection
```

3.3. *user_sistem/profile.php*

```html
@extends('layout.layout')

@section('title')
    Профил | {{Auth::user()->first_name .' '. Auth::user()->last_name}}
@endsection

@section('content')

    <div class="container content">
        <h1>Профил</h1>

        @include('messages')

        <h2>
            {{Auth::user()->first_name .' '. Auth::user()->last_name}}
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#nameModal">[Редактирай]</button>
        </h2>

        <table id="user-info-table">
            <tr>
                <td><strong>E-mail</strong></td>
                <td>{{Auth::user()->email}}</td>
                <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#emailModal">[Редактирай]</button></td>
            </tr>
            <tr>
                <td><strong>Телефон</strong></td>
                <td>{{Auth::user()->phone}}</td>
                <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#phoneModal">[Редактирай]</button></td>
            </tr>
            <tr>
                <td><strong>Парола</strong></td>
                <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#passwordModal">[Редактирай]</button></td>
                <td></td>
            </tr>
        </table>

    </div>


    <form method="POST">

        {{csrf_field()}}
        {{method_field('PUT')}}

        <input type="hidden" name="id" value="{{Auth::user()->id}}">

        <div class="modal fade" id="nameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Смяна на име</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-gorup">
                            <label for="first_name">Име</label>
                            <input class="form-control" type="text" name="first_name" id="first_name" value="{{Auth::user()->first_name}}">
                        </div>
                        <div class="form-gorup">
                            <label for="last_name">Фамилия</label>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="{{Auth::user()->last_name}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" name="edit_name" class="btn btn-warning">Редактирай</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Смяна на E-mail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-gorup">
                            <label for="email">E-mail</label>
                            <input class="form-control" type="email" name="email" id="email" value="{{Auth::user()->email}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" name="edit_email" class="btn btn-warning">Редактирай</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Смяна на телефон</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-gorup">
                            <label for="phone">Телефон</label>
                            <input class="form-control" type="number" name="phone" id="phone" value="{{Auth::user()->phone}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" name="edit_phone" class="btn btn-warning">Редактирай</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Смяна на парола</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-gorup">
                            <label for="old_password">Стара парола</label>
                            <input class="form-control" type="password" name="old_password" id="old_password">
                        </div>
                        <div class="form-gorup">
                            <label for="password">Нова парола</label>
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                        <div class="form-gorup">
                            <label for="password_confirm">Повторете новата парола</label>
                            <input class="form-control" type="password" name="password_confirm" id="password_confirm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" name="edit_password" class="btn btn-warning">Редактирай</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        #user-info-table td {
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>

@endsection
```

4. **Controller**:

4.1. *Users/LoginController.php*

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            return back()->with('error','Невалиден e-mail или парола!');
        }

        if(Hash::check($req->password, $user->password) || $user->password == $req->password && $user->password == 'password') {
            Auth::login($user);

            return redirect()->route('index');
        }

        return back()->with('error','Невалиден e-mail или парола!');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('index');
    }
}
```

4.2. *Users/RegisterController.php*

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
```

4.3. *Users/ProfileController.php*

```php
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
```

5. **Middleware** for the different roles: *RedirectIfNotAdmin*:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        if(Auth::user() == NULL || Auth::user()->role_id != 1) {
            return redirect('/');
        }

        return $next($request);
    }
}
```

6. In **Kernel.php** - last group below *'auth'* .. (on the second row): *'adminCheck' => \App\Http\Middleware\RedirectIfNotAdmin::class*,

7. **Using**:

7.1. In the *views*:

```php
@auth @endauth
@guest @endguest
{{Auth::user()->email}} // prints the e-mail on the current authenticated user
```

7.2. In the *routes*:

```php
Route::prefix('user')->group(function () {
    Route::group(['middleware' => 'guest', 'namespace' => 'Users'], function () {
        Route::get('login', 'LoginController@form')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('register', 'RegisterController@form')->name('register');
        Route::post('register', 'RegisterController@register');
    });

    Route::group(['middleware' => 'auth', 'namespace' => 'Users'], function () {
        Route::get('profile', 'ProfileController@index')->name('profile');
        Route::put('profile', 'ProfileController@update');
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
});
```