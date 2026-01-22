<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCategory extends Model
{
    protected $table = "user_category";

    protected $fillable = [
        'user_id',
        'category_id',
    ];


    /*
    * Define relationship to User model
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /*    
    * Define relationship to Category model
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
