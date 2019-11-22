@extends('layout.layout')

@section('title')
    @if($product)
        {{$product->title}}
    @endif
@endsection

@section('content')

    <div class="container">
        @if($product)
            <div class="row">
                <div class="product-image-gallery col-md-4">
                    <img class="product-img" src="{{URL::to('/')}}/images/product_images/product_{{$product->id}}/{{$product->main_image}}" onClick="showBigImageModal(this.src)">

                    @foreach($product->images as $image)
                        <div class="thumbnail">
                            @auth
                            @if(Auth::user()->role_id == 1)
                                <a href="#" onClick="if(confirm('Изтриване?')) location.href='{{route('product.delete_image', [$product->id, $image])}}'"><i class="fas fa-ban remove-img-icon"></i></a>
                            @endif
                            @endauth
                            <img class="img-thumbnail" src="{{URL::to('/')}}/images/product_images/product_{{$product->id}}/{{$image}}" onClick="showBigImageModal(this.src)">
                        </div>
                    @endforeach
                </div>

                <div class="product-buy-information col-md-8">
                    @include('messages')

                    <h3>{{$product->title}}</h3>
                    <p>Артикул номер: {{$product->id}}</p>
                    <p class="product-price">{{$product->price}} лв</p>
                    <p>Категория: {{$product->category}}</p>
                    <form method="POST" action='{{route('cart')}}'>
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <div class="form-group">
                            <label for="quanity">Количество</label>
                            <input class="form-control" id="quanity" name="quanity" type="number" value="1" min="1">
                        </div>
                        <button class="btn btn-primary" type="submit">Добави в количката</button>
                        @auth
                        @if(Auth::user()->role_id == 1)
                            <a href="{{route('product.edit', $product->id)}}" class="btn btn-warning" id="product1">Редактирай</a>
                            <a href="#" class="btn btn-danger" onClick="if(confirm('Изтриване?')) location.href='{{route('product.delete', $product->id)}}'">Изтрий</a>
                        @endif
                        @endauth
                        {{csrf_field()}}
                    </form>

                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <h3>Описание</h3>
                    <p class="product-description">
                        {{$product->description}}
                    </p>
                </div>
            </div>
        @else
            <p>Продукта вече не съществува</p>
        @endif
    </div>


    <div id="bigImageModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImg">
    </div>

    <script>
        // Get the modal
        var modal = $('#bigImageModal');
        var modalImg = $("#modalImg");

        function showBigImageModal(src) {
            modal.css("display", "block");
            modalImg.attr("src", src);
        }

        $("#bigImageModal").click(function() {
            modal.css("display", "none");
        });
    </script>


    <style>
        .product-img {
            width: 100%;
            cursor: pointer;
        }
        .thumbnail {
            position: relative;
            display: inline-block;
            width: 100px;
            height: 100px;
            margin: 2px;
        }
        .img-thumbnail {
            width: 100%;
            height: 100%;
        }
        .img-thumbnail:hover {
            border-color: blue;
            cursor: pointer;
        }
        .remove-img-icon {
            position: absolute;
            top: 2px;
            right: 2px;
            color: red;
            background-color: white;
            border-radius: 10px;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 100; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (Image) */
        .modal-content {
            max-width: 100%;
            max-height: 100vh;
            width: auto;
            height: auto;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
        }


        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            z-index: 101;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

@endsection