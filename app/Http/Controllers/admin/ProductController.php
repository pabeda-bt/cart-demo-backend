<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function show(int $id, Request $request) {
        return Product::findOrFail($id);
    }

    public function put(int $id, Request $request) {
        $product=Product::findOrFail($id);
        $product->fill($request->all());

        $product->update();
        return $product;
    }

    public function delete(int $id) {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function post(Request $request) {
        return Product::create($request->all());
    }

    public function get(Request $request) {
        return Product::all();
    }

}
