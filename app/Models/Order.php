<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = "orders";

    protected $fillable = [
        'invoice_id',
        'purchaser_id',
        'invoice_number',
        'order_date',
    ];



    /*    
    * Define relationship to OrderItem model
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    /*    
    * Define relationship to User model as purchaser
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchaser_id');
    }
}
