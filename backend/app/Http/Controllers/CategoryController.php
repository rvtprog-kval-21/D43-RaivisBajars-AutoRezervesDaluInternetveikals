<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::select('id', 'category_name', 'parent_category', 'image', 'visibility')->get();
        setlocale(LC_COLLATE, 'en_US.utf8');

        foreach ($category as $value) {
            $value->url=iconv('UTF-8', 'ASCII//TRANSLIT', preg_replace('/[^\p{L}\p{N}]/u', '-', $value->category_name));
            $value->url = mb_strtolower($value->url);
        }
        return $category;
    }
 
    public function add(Request $request)
    {
        $category = new Category([
            'category_name' => $request->input('category_name'),
            'parent_category' => $request->input('parent_category'),
            'image' => $request->input('image')
        ]);
        $category->save();
 
        return response()->json('Kategorija pievienota');
    }
 
    public function edit($id)
    {
        $category = Cateogry::find($id);
        return response()->json($category);
    }
 
    public function update($id, Request $request)
    {
        $category = Category::find($id);
        $category->update($request->all());
 
        return response()->json('Kategorija atjaunota');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
 
        return response()->json('Kategorija izdzēsta');
    }

    public function getCategories(Request $request)
    {
        $category = Category::where('category_name', 'LIKE','%'.$request->keyword.'%')->get();
        return response()->json($category); 
    }
}
