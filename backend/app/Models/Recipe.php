<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasApiTokens;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'recipeId'
    ];

    /**
     * This function returns the User wich Id is assigned
     * to the Recipe. The user has created the recipe
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    /**
     * This function returns the images associated
     * to a Recipe
     */
    public function images(){

        return $this->hasMany(Image::class);
    }

    /**
     * This function returns the categories associated
     * to the recipe in a many-to-many relationship
     */
    public function categories(){

        return $this->belongsToMany(Category::class);
    }

    /**
     * This function returns the ingredients associated
     * to the recipe in a many-to-many relationship
     */
    public function ingredients(){

        return $this->belongsToMany(Ingredient::class)->withPivot('grams');
    }

    /**
     * This function returns the plannings associated
     * to the recipe in a many-to-many relationship
     */
    public function plannings(){

        return $this->belongsToMany(Planning::class)->withPivot('meal');
    }


}
