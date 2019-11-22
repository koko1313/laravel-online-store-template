@extends('layout.layout')

@section('title')
    {{$category_name}}
@endsection

@section('content')

<h1>{{$category_name}}</h1>

<div class="store-grid row">
    <div class="col-md">
        @foreach($products as $product)
            <div class="product" name="{{$product->title}}">
                <img src="{{URL::to('/')}}/images/product_images/product_{{$product->id}}/{{$product->main_image}}">

                <div>
                    <h5>{{$product->title}}</h5>
                    <p>{{$product->price}} лв</p>
                    <a href="{{route('open.product', $product->id)}}" class="btn btn-primary">Отвори</a>

                    @auth
                    @if(Auth::user()->role_id == 1)
                        <a href="{{route('product.edit', $product->id)}}" class="btn btn-warning">Редактирай</a>
                        <a href="#" class="btn btn-danger" onClick="if(confirm('Изтриване?')) location.href='{{route('product.delete', $product->id)}}'">Изтрий</a>
                    @endif
                    @endauth
                </div>
            </div>
        @endforeach

        {{$products->links()}}

    </div>
</div>

<style>
.store-grid {
    text-align: center;
}

.pagination {
    width: fit-content;
    margin: 0 auto;
}

.product {
    position: relative;
    display: inline-block;
    width: 288px;
    height: 400px;
    overflow: hidden;
    margin: 5px;
    border: 1px solid gray;
    border-radius: 5px;
    padding: 2px;
    box-shadow: 3px 3px 5px grey;
}

.product img {
    max-width: 100%;
    max-height: 250px;
    width: auto;
    height: auto;
}

.product div {
    position: absolute;
    bottom: 5px;
    width: 100%;
}
</style>

@endsection