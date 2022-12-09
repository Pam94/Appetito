<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class IngredientCategory extends Model
{
    use HasApiTokens;

     /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'ingredientCategoryId'
    ];

    /**
     * This function returns the ingredients associated
     * with a category
     */
    public function ingredients(){

        return $this->hasMany(Ingredient::class);
    }
}
