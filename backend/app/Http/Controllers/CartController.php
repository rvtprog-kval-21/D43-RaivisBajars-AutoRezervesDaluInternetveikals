<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function show($user_id)
    {
        $cart = Cart::select('cart_id', 'user_id', 'product_id', 'product_name', 'product_price', 'product_image', 'quantity')->where('user_id', $user_id)->get();

        return response()->json($cart);
    }

    public function add(Request $request)
    {
        $cart = new Cart([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'product_image' => $request->input('product_image'),
            'quantity' => $request->input('quantity')
        ]);
        $cart->save();
 
        return response()->json('Prece pievienota');
    }

    public function update($cart_id, Request $request)
    {
        $cart = Cart::find($cart_id);
        $cart->update($request->all());
 
        return response()->json($cart);
    }

    public function delete($cart_id)
    {
        $cart = Cart::find($cart_id);
        $cart->delete();
 
        return response()->json($cart);
    }

    public function deleteAllUserItems($user_id)
    {
        $cart = Cart::where('user_id', 'like', $user_id)->delete();
        return response()->json($cart);
    }
    
}
