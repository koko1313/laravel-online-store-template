<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    public function form() {
        return view('shop.category_form');
    }

    public function store(Request $req) {
        $this->validate($req, [
            'category' => 'required'
        ]);

        $category = new Category();
        $category->category = $req['category'];

        if($category->save()) {
            return back()->with('success', 'Успешно добавена категория');
        }

        return back()->with('error', 'Категорията не беше добавена успешно');
    }

    public function edit($id) {
        $category = Category::getCategory($id)->category;
        return view('shop.category_form', ['category_id' => $category]);
    }

    public function update(Request $req) {
        $this->validate($req, [
            'category' => 'required'
        ]);

        Category::where('id', $req->id)->update(['category' => $req->category]);
        return redirect()->route('shop');
    }

    public function delete($id) {
        Category::where('id', $id)->delete();
        return redirect()->route('shop');
    }

}