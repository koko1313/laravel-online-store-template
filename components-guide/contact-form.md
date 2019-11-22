# Contact form

1. **Controller**: *ContactController.php*. Also set up the email and subject here

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller{

    public function form() {
        return view('contact');
    }

    public function send(Request $req) {
        $this->validate($req, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        ini_set("SMTP","ssl://smtp.gmail.com"); // SMTP
        ini_set("smtp_port","465"); // SMTP port
        $to = "kaloyanvelchkov@gmail.com"; // administrator's email
        $subject = "The site"; // subject of the email

        $name = $req->name;
        $phone = $req->phone;
        $email = $req->email;
        $comment = $req->message;

        $message = "Име: ".$name." \r\nТелефон: ".$phone."\r\n\r\nСъобщение: \r\n" . $comment;
        $headers = "From: " . $email;
        //send_mail($message, "From: " . $email);

        mail($to, $subject, $message, $headers);
    }

}
```

2. **Routes**:

```php
Route::get('contact', 'ContactController@form')->name('contact');
Route::post('contact', 'ContactController@send');
```

3. **View**: *contact.blade.php*

```html
@extends('layout.layout')

@section('title')
    Контакти
@endsection

@section('content')

<h1>Свържете се с нас</h1>

@include('messages')

<form method="POST">
    <div class="form-group">
        <label for="name">Име и фамилия</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Име и фамилия">
    </div>

    <div class="form-group">
        <label for="phone">Телефон</label>
        <input type="text" class="form-control" name="phone" id="phone" maxlength="10" placeholder="0812345678">
    </div>

    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="your@mail.com">
    </div>

    <div class="form-group">
        <label for="message">Съобщение</label>
        <textarea class="form-control" rows="5" name="message" id="message" placeholder="Здравейте ..."></textarea>
    </div>

    {{csrf_field()}}

    <button type="submit" name="submit" class="btn btn-primary form-control">Изпрати</button>
</form>

@endsection
```