<?php

namespace App\Http\Controllers\User;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
        public function addToCart(Request $request) {
            $product_id=$request->get('product_id');
            $count = $request->get('count');

            $product = Product::findOrFail($product_id);
            $user = $this->getAuthUser($request);

            $activeCart = $this->getActiveCart($user);

            if (!$item=$activeCart->items()->where('product_id',$product->id)->first()) {
                $item = $activeCart->items()->create([
                    'product_id'=>$product_id,
                    'count'=>$count,
                    'total_price'=>$count*$product->price
                ]);
            } else {
                $item->count = $count;
                $item->total_price = $count*$product->price;
                $item->save();
            }

            return $activeCart->load('items.product');

        }

        public function deleteItem(int $id, Request $request) {
            $user = $this->getAuthUser($request);
            $activeCart = $this->getActiveCart($user);

            $activeCart->items()->where('id',$id)->delete();

        }

        public function getCart(Request $request) {

            $user = $this->getAuthUser($request);
            return $this->getActiveCart($user);

        }

        public function order(Request $request){
            $user=$this->getAuthUser($request);
            $activeCart = $this->getActiveCart($user);

            $activeCart->status='ordered';
            $activeCart->save();
        }

        private function getActiveCart($user) {
            if (!$activeCart = $user->carts()->where('status','active')->first()) {
                $activeCart=$user->carts()->create([
                    'status'=>'active'
                ]);
            }
            $activeCart->load('items.product');

            return $activeCart;
        }

        private function getAuthUser(Request $request){
            return User::where('token',$request->header('Authorization'))->firstOrFail();
        }
}
