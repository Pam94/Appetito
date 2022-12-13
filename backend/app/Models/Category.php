<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
     * This function returns the recipes associated
     * to a category in a many-to-many relationship
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }

    /**
     * This function returns the User wich Id is assigned
     * to the Category. The user has created the category
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
