<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that   are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'image'
    ];

    /**
     * This function returns the Recipe which 
     * has an image associated to
     */
    public function recipe(){

        return $this->belongsTo(Recipe::class);
    }
}
