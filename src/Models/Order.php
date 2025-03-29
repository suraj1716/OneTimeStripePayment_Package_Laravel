<?php

namespace Suraj1716\Onetimestripe\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';  // Make sure the table name matches your database table.
    protected $fillable = ['status', 'total_price', 'session_id'];  // Make sure you have the necessary columns


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}

