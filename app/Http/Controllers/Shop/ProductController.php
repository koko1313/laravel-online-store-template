<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Gumlet\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller {

    public function form() {
        $categories = Category::getAllCategories();
        return view('shop.product_form', ['categories' => $categories]);
    }

    public function store(Request $req) {
        $this->validateProductInput($req);
        $this->validate($req, ['main_image' => 'required']);

        if(Product::where('id', $req->id)->count() > 0) {
            return redirect()->back()->with('error', 'Това id вече е добавено за друг продукт!')->withInput(Input::all());
        }

        $product = new Product();
        $product->id = $req->id;
        $product->title = $req->title;
        $product->price = $req->price;
        $product->description = $req->description;
        $product->category_id = $req->category_id;
        $product->main_image = $this->move_main_image($req['main_image'], $req->id);
        $product->images = $this->move_images($req['images'], $req->id, 0);

        if($product->save()) {
            return back()->with('success', 'Продукта беше добавен успешно');
        }

        return back()->with('error', 'Проблем при добавянето на продукта');
    }

    public function edit($id) {
        $categories = Category::getAllCategories();
        $product = Product::getProduct($id);
        return view('shop.product_form', ['product' => $product, 'categories' => $categories]);
    }

    public function update($id, Request $req) {
        $this->validateProductInput($req);

        if($req['main_image']) {
            array_map('unlink', glob('images/product_images/product_'. $req->id .'/main.*'));
            $main_image = $this->move_main_image($req['main_image'], $req->id);
        } else {
            $main_image = Product::getProductMainImage($id);
        }

        // проверяваме кое е последното качено изображение като номер
        $images = Product::getProductImages($id);
        if($images) {
            $images_array = explode(';', $images); // масив с всички изображения
            $last_image = $images_array[sizeof($images_array)-2]; // цялото име на последото изображение
            $last_added_image = explode('.', $last_image)[0]; // номера на последното изображение
            $last_added_image++;
        } else {
            $last_added_image = 0;
        }

        $images .= $this->move_images($req['images'], $req->id, $last_added_image);

        if(Product::where('id', $id)->update(['id' => $req->id, 'title' => $req->title, 'price' => $req->price, 'description' => $req->description, 'category_id' => $req->category_id, 'main_image' => $main_image, 'images' => $images])) {
            // ако сменим id-то, преименуваме директорията
            if($id != $req->id) {
                rename('images/product_images/product_'. $id .'/', 'images/product_images/product_'. $req->id .'/');
            }
            return redirect()->route('open.category', $req->category_id);
        }

        return back()->with('error', 'Проблем при редактирането на продукта');
    }

    public function delete($id) {
        $category_id = Product::getProduct($id)->category_id; // взимаме категорията, за да после да се върнем на страницата с категория
        if(Product::where('id', $id)->delete()) {
            $this->rmdir_recursive('images/product_images/product_'. $id);
        }
        return redirect()->route('open.category', $category_id);
    }

    public function delete_image($product_id, $image) {
        $images_from_db = Product::getProductImages($product_id);
        $images_from_db = str_replace($image.';','',$images_from_db); // изтриваме изображението от низа
        // връщаме низа без изображението в базата
        if(Product::where('id', $product_id)->update(['images' => $images_from_db])) {
            unlink('images/product_images/product_'. $product_id .'/'. $image); // изтриваме изображението от директорията
            return redirect()->back();
        }
    }

    function rmdir_recursive($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }

    // валидира входните данни за формата за продукт
    function validateProductInput($req) {
        $this->validate($req, [
            'id' => 'required',
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required',
            'images.*' => 'image'
        ]);
    }

    // мести снимката в папката и връща низ с името и
    function move_main_image($main_image, $req_id) {
        if($main_image) {
            $fileExtension = $main_image->getClientOriginalExtension();
            $fileName = 'main.'. $fileExtension;
            $filePath = 'images/product_images/product_'. $req_id .'/';

            if($main_image->move($filePath, $fileName)) {
                $image = new ImageResize($filePath .'/'. $fileName);
                $image->resizeToWidth(800);
                $image->save($filePath .'/'. $fileName);
                return $main_image = $fileName;
            } else {
                return back()->with('error', 'Проблем при добавянето на продукра. Моля опитайте отново. Проблем с качването на снимката.');
            }
        } else {
            return back()->with('error', 'Моля, изберете снимка');
        }
    }

    // мести снимките в папката и връща низ с имената им
    function move_images($images, $req_id, $start_from) {
        $images_string = "";
        if($images) {
            $i = $start_from;
            foreach($images as $image) {
                $fileExtension = $image->getClientOriginalExtension();
                $fileName = $i .'.'. $fileExtension;
                $filePath = 'images/product_images/product_'. $req_id .'/';
                if($image->move($filePath, $fileName)) {
                    $image = new ImageResize($filePath .'/'. $fileName);
                    $image->resizeToWidth(800);
                    $image->save($filePath .'/'. $fileName);
                    $images_string .= $fileName .';';
                    $i++;
                } else {
                    return back()->with('error', 'Проблем при добавянето на продукта. Моля опитайте отново. Проблем с качването на снимките.');
                }
            }
        }
        return $images_string;
    }
}