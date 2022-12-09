<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class IngredientCategory extends Model
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
    ];

    /**
     * This function returns the ingredients associated
     * with a category
     */
    public function ingredients(){

        return $this->hasMany(Ingredient::class);
    }
}
