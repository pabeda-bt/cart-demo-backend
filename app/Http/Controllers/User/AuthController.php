<?php

namespace App\Http\Controllers\User;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $user = User::create($request->all());

        $user->token = str_random(40);
        $user->save();

        return $user;
    }

    public function login(Request $request){
        return User::where('email',$request->get('email'))
            ->where('password',$request->get('password'))
            ->firstOrFail();
    }

}