<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
    ];

    /**
     * This function returns the user responsible
     * of creating the planning
     */
    public function user(){

        return $this->belongsTo('userId');
    }
}
