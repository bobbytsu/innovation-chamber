<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        
    ];

    /**
     * Relationship one to many terhadap tabel users
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}