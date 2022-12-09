<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'categoryId'
    ];

     /**
     * This function returns the recipes associated
     * to a category in a many-to-many relationship
     */
    public function recipes(){

        return $this->belongsToMany(Recipe::class);
    }
}
