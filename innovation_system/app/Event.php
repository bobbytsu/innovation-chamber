<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Atribut yang dapat di mass assignment
     */
    protected $fillable = ['user_id', 'title', 'start', 'end', 'endplus', 'description'];

    /**
     * Relationship one to many terhadap tabel users
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
