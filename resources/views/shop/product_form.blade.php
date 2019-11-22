@extends('layout.layout')

@section('title')
    Продукт - форма
@endsection

@section('content')

<div class="container">

    @include('messages')

    <form id="form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="id">Артикул номер</label>
            <input type="text" class="form-control" id="id" name="id"
                @if(isset($product) && !old('id'))
                    value="{{$product->id}}"
                @else
                    value="{{old('id')}}"
                @endif
            >
        </div>

        <div class="form-group">
            <label for="title">Име на продукта</label>
            <input type="text" class="form-control" id="title" name="title"
                @if(isset($product) && !old('title'))
                    value="{{$product->title}}"
                @else
                    value="{{old('title')}}"
                @endif
            >
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <div class="input-group">
                <input type="text" class="form-control" id="price" name="price"
                    @if(isset($product) && !old('price'))
                        value="{{$product->price}}"
                    @else
                       value="{{old('price')}}"
                    @endif
                >
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">лв.</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea class="form-control" id="description" name="description">@if(isset($product) && !old('description')){{$product->description}}@else{{old('description')}}@endif</textarea> <!--################-->
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select class="form-control" id="category_id" name="category_id">
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->category}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="main_image">Главна снимка</label>
            <input type="file" class="form-control-file" id="main_image" name="main_image">
        </div>

        <div class="form-group">
            <label for="images">Снимки</label>
            <input type="file" class="form-control-file" id="images" name="images[]" multiple>
        </div>

        {{csrf_field()}}

        @if(isset($product))
            {{method_field('PUT')}}
            <button class="form-control btn btn-warning" id="submit" type="submit" name="edit">Редактирай</button>
        @else
            <button class="form-control btn btn-primary" id="submit" type="submit" name="add">Добави</button>
        @endif

    </form>

</div>

@endsection