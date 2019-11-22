# Corousel

1. **Model**: *Carousel.php*

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Carousel extends Model {
protected $table = 'carousel';

protected $fillable = ['title', 'description', 'image'];

public static function getCarouselImage($id) {
return DB::select('SELECT * FROM carousel WHERE id=?', array($id))[0];
}

}
```

2. **Controller**: *CarouselConstroller.php*

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
public function create() {
return View('carousel.form');
}

public function edit($id) {
$carousel_image = Carousel::getCarouselImage($id);
return View('carousel.form', ["carousel_image" => $carousel_image]);
}

public function store(Request $req) {
$image = $req['image'];

if($image) {
$fileName = $image->getClientOriginalName();
$image->move('images/carousel_images', $fileName);
$req['img_path'] = $fileName;
} else {
return back()->with('error', 'Моля, изберете снимка');
}

$carousel_image = new Carousel();
$carousel_image->title = $req['title'];
$carousel_image->description = $req['description'];
$carousel_image->image = $req['img_path'];

if($carousel_image->save()) {
return back()->with('success', 'Успешо добавена снимка');
} else {
return back()->with('error', 'Снимката не беше добавена успешно');
}
}

public function update($id, Request $req) {
Carousel::where('id', $id)->update(['title' => $req->title, 'description' => $req->description]);
return redirect()->route('index'); // редиректваме
}

public function delete($id) {
$img = Carousel::getCarouselImage($id);
$img_name = $img->image;

Carousel::where('id', $id)->delete();
unlink('images/carousel_images/'.$img_name);
return redirect()->back();
}

}
```
	
3. **View**:  
3.1. *carousel/index.blade.php*

```html
<div id="slideshow">
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

<?php
$result_carousel = DB::select("SELECT * FROM carousel");
?>

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

<div class="carousel-img-edit">
<a class="btn btn-link" href="{{route('carousel.edit', $row_carousel->id)}}"><i class="fas fa-edit"></i></a>

<form method="POST" action="{{route('carousel.delete', $row_carousel->id)}}">
{{method_field('DELETE')}}
{{csrf_field()}}
<button type="submit" class="btn btn-link" onclick="return confirm('Are you sure ?');"><i class="fas fa-trash-alt"></i></button>
</form>


</div>
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

<div id="edit-carousel">
<a href="{{ route('carousel.add') }}">Добави снимки в слайдшоуто</a>
</div>
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
```

3.2. *carousel/form.blade.php*
```html
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
```

4. **Routes**:

```php
Route::prefix('carousel')->middleware('adminCheck')->group(function () {
    Route::get('form', 'CarouselController@create')->name('carousel.add');
    Route::post('form', 'CarouselController@store');
    Route::get('edit/{id}', 'CarouselController@edit')->name('carousel.edit');
    Route::put('edit/{id}', 'CarouselController@update');
    Route::delete('delete/{id}', 'CarouselController@delete')->name('carousel.delete');
});
```

5. Include it wherever you want like this:

```php
@include("carousel.index")
```