<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = ['product_name', 'product_image', 'brand_id', 'category_id', 'product_price', 'quantity'];
}
