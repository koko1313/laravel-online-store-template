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