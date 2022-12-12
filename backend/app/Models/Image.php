<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
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
     * This function returns the Recipe which 
     * has an image associated to
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
