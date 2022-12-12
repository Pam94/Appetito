<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * This function returns all the recipes
     * the User has been created
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * This function returns all the ingredients
     * the User has been created
     */
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }


    /**
     * This function returns all the plannings
     * the User has been created
     */
    public function plannings()
    {
        return $this->hasMany(Planning::class);
    }
}
