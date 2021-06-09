<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    protected $fillable = ['user_id', 'product_id', 'brand_id', 'product_name', 'product_price', 'product_image', 'quantity'];
}
