<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        'sku',
        'name',
        'price',
    ];


    /*
    * Define relationship to OrderItem model
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
