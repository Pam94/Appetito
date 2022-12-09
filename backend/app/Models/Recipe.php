<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'time',
        'portions',
        'instructions',
        'favorite',
        'url',
        'video'
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
}
