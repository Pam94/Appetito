<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientCategory extends Model
{

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * This function returns the ingredients associated
     * with a category
     */
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
