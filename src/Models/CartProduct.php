<?php

// app/Models/CartProduct.php

namespace Suraj1716\Onetimestripe\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CartProduct extends Pivot
{
    protected $table = 'onetimestripe_cart_product';
}
