<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // all posts
    public function index()
    {
        $category = Category::select('id', 'category_name', 'parent_category', 'image')->get();
        setlocale(LC_COLLATE, 'en_US.utf8');

        foreach ($category as $value) {
            $value->url=iconv('UTF-8', 'ASCII//TRANSLIT', preg_replace('/[^\p{L}\p{N}]/u', '-', $value->category_name));
            $value->url = strtolower($value->url);
        }
        return $category;
    }
 
    // add post
    public function add(Request $request)
    {
        $category = new Category([
            'category_name' => $request->input('category_name'),
            'parent_category' => $request->input('parent_category'),
        ]);
        $category->save();
 
        return response()->json('The post successfully added');
    }
 
    // edit post
    public function edit($id)
    {
        $category = Cateogry::find($id);
        return response()->json($category);
    }
 
    // update post
    public function update($id, Request $request)
    {
        $category = Category::find($id);
        $category->update($request->all());
 
        return response()->json('The post successfully updated');
    }
 
    // delete post
    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
 
        return response()->json('The post successfully deleted');
    }
}
