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