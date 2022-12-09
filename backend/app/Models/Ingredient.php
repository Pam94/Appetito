<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasApiTokens;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon',
        'pantry',
        'shoplist'
    ];

    /**
     * This function returns the User wich Id is assigned
     * to the Ingredient. The user has created the ingredient
     */
    public function user(){

        return $this->belongsTo(User::class);
    }

    public function categories(){

        return $this->hasMany(IngredientCategory::class, 'ingredientCategoryId');
    }
}
