<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function show($category_id){
        $product = DB::table('products')
                        ->join('brands', 'products.brand_id', '=', 'brands.brand_id')
                        ->select('products.*', 'brands.brand_name')
                        ->where('category_id', $category_id)
                        ->get();

        foreach ($product as $value) {
            $value->url=iconv('UTF-8', 'ASCII//TRANSLIT', preg_replace('/[^\p{L}\p{N}]/u', '-', $value->product_name));
            $value->url = strtolower($value->url);
        }               

        return response()->json($product);
    }

    public function index()
    {
        $product = DB::table('products')
                        ->join('brands', 'products.brand_id', '=', 'brands.brand_id')
                        ->select('products.*', 'brands.brand_name')
                        ->get();

        foreach ($product as $value) {
            $value->url=iconv('UTF-8', 'ASCII//TRANSLIT', preg_replace('/[^\p{L}\p{N}]/u', '-', $value->product_name));
            $value->url = strtolower($value->url);
        }

        return response()->json($product);
    }
    
    public function add(Request $request)
    {
        $product = new Product([
            'product_name' => $request->input('product_name'),
            'product_image' => $request->input('product_image'),
            'brand_id' => $request->input('brand_id'),
            'category_id' => $request->input('category_id'),
            'product_price' => $request->input('product_price'),
            'quantity' => $request->input('quantity')
        ]);
        $product->save();
 
        return response()->json('Prece pievienota');
    }
 
    public function edit($product_id)
    {
        $product = Product::find($product_id);
        return response()->json($product);
    }
 
    public function update($product_id, Request $request)
    {
        $product = Product::find($product_id);
        $product->update($request->all());
 
        return response()->json('The post successfully updated');
    }
 
    public function delete($product_id)
    {
        $product = Product::find($product_id);
        $product->delete();
 
        return response()->json('The post successfully deleted');
    }

    public function getProducts(Request $request)
    {
        $product = DB::table('products')
                        ->join('brands', 'products.brand_id', '=', 'brands.brand_id')
                        ->select('products.*', 'brands.brand_name')
                        ->where('product_name', 'LIKE','%'.$request->keyword.'%')
                        ->get();
        return response()->json($product); 
    }
}
