@extends('layout.layout')

@section('title')
    Категория - форма
@endsection

@section('content')

    <div class="container">

        @include('messages')

        <form id="form" method="POST">
            <div class="form-group">
                <label for="category">Категория</label>
                <input type="text" class="form-control" id="category" name="category" @if(isset($category_id)) value="{{$category_id}}" @endif>
            </div>

            {{csrf_field()}}

            @if(isset($category_id))
                {{method_field('PUT')}}
                <input type="hidden" value="{{$category_id}}">
                <button class="form-control btn btn-warning" id="submit" type="submit" name="edit">Редактирай</button>
            @else
                <button class="form-control btn btn-primary" id="submit" type="submit" name="add">Добави</button>
            @endif
        </form>

    </div>

@endsection