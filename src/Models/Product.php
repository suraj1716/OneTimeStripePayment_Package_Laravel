<?php

// app/Models/Product.php

namespace Suraj1716\Onetimestripe\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}

