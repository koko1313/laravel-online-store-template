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
