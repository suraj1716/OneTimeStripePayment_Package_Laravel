<?php

// app/Models/Cart.php

namespace Suraj1716\Onetimestripe\Models;

use Suraj1716\Onetimestripe\Models\User;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_products')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


