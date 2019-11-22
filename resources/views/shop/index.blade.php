@extends('layout.layout')

@section('title')
    Магазин
@endsection

@section('content')

<div class="container">
    <div class="row">

        <ul class="list-group list-group-flush col-md-2">
            @foreach($categories as $category)
                <li class="list-group-item">
                    <a href="{{route('open.category', $category->id)}}" class="category-button" id="{{$category->id}}">{{$category->category}}</a>
                    @auth
                    @if(Auth::user()->role_id == 1)
                        <a href="{{route('category.edit', ['id' => $category->id])}}"><i class="fas fa-edit"></i></a>
                        <a href="#" onClick="if(confirm('Изтриване?')) location.href='{{route('category.delete', ['id' => $category->id])}}'"><i class="fas fa-trash-alt"></i></a>
                    @endif
                    @endauth
                </li>
            @endforeach
        </ul>

        <div class="col-md-10">

            <div class="row">
                <div class="col-md-8">
                    @auth
                    @if(Auth::user()->role_id == 1)
                        <a href="{{route('category.add')}}">Добави Категория</a> |
                        <a href="{{route('product.add')}}">Добави продукт</a>
                    @endif
                    @endauth
                </div>

                <div class="input-group col-md-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-search"></i></div>
                    </div>
                    <input type="text" id="search" class="form-control" placeholder="Търси в категорията...">
                </div>
            </div>

            <div class="row">
                <div class="col-md">
                    Съдържание
                </div>
            </div>

        </div>

    </div>
</div>

<script>
// търсене
$("#search").on('keyup', function() {
    var search = $("#search").val();
    var products = $(".product");

    if (search != "") {
        for(var i=0; i<products.length; i++) {
            var keywords = $(products[i]).attr("name");

            if(keywords.toLowerCase().includes(search.toLowerCase())) {
                //$(products[i]).css("display", "inline-block");
                $(products[i]).fadeIn();
            } else {
                //$(products[i]).css("display", "none");
                $(products[i]).fadeOut();
            }
        }
    } else {
        for(var i=0; i<products.length; i++) {
            $(products[i]).fadeIn();
        }
    }
});
</script>

@endsection