<div id="slideshow" class="jumbotron">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

        <?php $result_carousel = DB::select("SELECT * FROM carousel"); ?>

        <ol class="carousel-indicators">
            <?php $active = "active"; ?>
            @for ($i=0; $i<sizeof($result_carousel); $i++)
                <li data-target="#carouselExampleControls" data-slide-to="{{ $i }}" class="{{ $active }}"></li>
                <?php $active = ""; ?>
            @endfor
        </ol>

        <div class="carousel-inner">

            @if (sizeof($result_carousel) > 0)
                <?php $active = "active"; ?>
                @foreach($result_carousel as $row_carousel)
                    <div class="carousel-item {{ $active }}">
                        <img class="d-block w-100" src="{{URL::to('/')}}/images/carousel_images/{{ $row_carousel->image }}" alt="'. $row_carousel->description .'">
                        <div class="carousel-caption d-none d-md-block">
                            <h5> {{ $row_carousel->title }} </h5>
                            <p> {{ $row_carousel->description }} </p>
                        </div>

                        @auth
                        @if(Auth::user()->role_id == 1)
                            <div class="carousel-img-edit">
                                <a class="btn btn-link" href="{{route('carousel.edit', $row_carousel->id)}}"><i class="fas fa-edit"></i></a>

                                <form method="POST" action="{{route('carousel.delete', $row_carousel->id)}}">
                                    {{method_field('DELETE')}}
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure ?');"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        @endif
                        @endauth
                    </div>
                    <?php $active = ""; ?>
                @endforeach
            @else
                <div class="carousel-item active">
                    <div style="height: 350px"></div>
                </div>
            @endif

        </div>

    </div>

    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

    @auth
    @if(Auth::user()->role_id == 1)
        <div id="edit-carousel">
            <a href="{{ route('carousel.add') }}">Добави снимки в слайдшоуто</a>
        </div>
    @endif
    @endauth
</div>

<style>
    #slideshow {
        padding: 0;
        display: block;
        position: relative;
        max-height: 350px;
    }

    .carousel-item img {
        max-height: 350px!important;
    }

    .carousel-img-edit {
        position: absolute;
        top: 10px;
        right: 20%;
    }

    .carousel-img-edit button, .carousel-img-edit a{
        font-size: 1.5em;
    }

    .carousel-img-edit form { display: inline }

    #edit-carousel {
        position: absolute;
        top: 10px;
        right: 10px
    }
</style>