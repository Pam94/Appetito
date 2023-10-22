<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasUuids, HasFactory;
    
    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * This function returns the User wich Id is assigned
     * to the Ingredient. The user has created the ingredient
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * This function returns the category associated with
     * an ingredient
     */
    public function category()
    {
        return $this->belongsTo(IngredientCategory::class);
    }

    /**
     * This function returns the recipes associated
     * to an ingredient in a many-to-many relationship
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
