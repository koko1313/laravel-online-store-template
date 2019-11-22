@extends('layout.layout')

@section('title')
    Слайдшоу
@endsection

@section('content')

<div class="container content">
    <h1>Изображение за слайдшоуто</h1>

    @include('messages')

    <form method="POST" enctype="multipart/form-data">

        @if(!isset($carousel_image))
        <div class="form-group">
            <label for="image">Снимка</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        @endif

        <div class="form-group">
            <label for="title">Заглавие</label>
            <input type="text" class="form-control" id="title" name="title" @if(isset($carousel_image)) value="{{$carousel_image->title}}" @endif>
        </div>

        <div class="form-group">
            <label for="description">Кратко описание</label>
            <input type="text" class="form-control" id="description" name="description" @if(isset($carousel_image)) value="{{$carousel_image->description}}" @endif>
        </div>

        {{csrf_field()}}

        @if(isset($carousel_image))
            {{method_field('PUT')}}
            <button class="form-control btn btn-warning" name="submit">Редактирай</button>
        @else
            <button class="form-control btn btn-primary" name="submit">Добави</button>
        @endif

    </form>
</div>

@endsection