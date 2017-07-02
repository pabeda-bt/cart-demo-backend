<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Request;

class CartController extends Controller
{
    public function show(int $id, Request $request) {
        return Cart::findOrFail($id)->with('items.products');
    }

    public function delete(int $id) {
        $cart = Cart::findOrFail($id);
        $cart->items()->delete();
        return $cart->delete();
    }

    public function get(Request $request) {
        return Cart::all()->with('items.products');
    }
}
