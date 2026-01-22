<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = "order_items";

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];


    /*
    * Define relationship to Order model
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


    /*    
    * Define relationship to Product model
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
