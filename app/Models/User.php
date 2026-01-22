<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'referred_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*    
    * Define relationship to Order model as purchaser
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function orders()
    {
        return $this->hasMany(Order::class, 'purchaser_id');
    }


    /*    
    * Define relationship to UserCategory model
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function userCategories()
    {
        return $this->hasMany(UserCategory::class);
    }


    /*    
    * Define relationship to User model as distributor (referrer)
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function distributor()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }


    /*    
    * Define relationship to User model as referred customers
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function referredCustomers()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /*    
    * Define relationship to Category model through UserCategory model
    * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
    */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'user_category',
            'user_id',
            'category_id'
        );
    }
}
