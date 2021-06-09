<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show($user_id)
    {
        $order = Order::select('order_id', 'user_id', 'status', 'delivery', 'products', 'price')->where('user_id', $user_id)->get();

        return response()->json($order);
    }

    public function add(Request $request)
    {
        $order = new Order([
            'user_id' => $request->input('user_id'),
            'status' => $request->input('status'),
            'delivery' => $request->input('delivery'),
            'products' => $request->input('products'),
            'price' => $request->input('price')
        ]);
        $order->save();
 
        return response()->json('Pasūtījums pievienots');
    }

    public function update($order_id, Request $request)
    {
        $order = order::find($order_id);
        $order->update($request->all());
 
        return response()->json($order);
    }

    public function delete($order_id)
    {
        $order = Order::find($order_id);
        $order->delete();
 
        return response()->json($order);
    }
}
