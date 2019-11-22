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