<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasApiTokens;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'planningId'
    ];

    /**
     * This function returns the user responsible
     * of creating the planning
     */
    public function user(){

        return $this->belongsTo('userId');
    }

    /**
     * This function returns the recipes associated
     * to a planning in a many-to-many relationship
     */
    public function recipes(){

        return $this->belongsToMany(Recipe::class)->withPivot('meal');
    }
}
