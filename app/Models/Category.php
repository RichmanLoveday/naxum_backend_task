<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $fillable = [
        'name',
    ];


    /*    
    * Define relationship to UserCategory model
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function userCategories()
    {
        return $this->hasMany(UserCategory::class);
    }
}
