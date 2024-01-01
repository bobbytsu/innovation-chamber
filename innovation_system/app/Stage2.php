<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage2 extends Model
{
    /**
     * Atribut yang dapat di mass assignment
     */
    protected $fillable = [
        'post_img', 'title', 'description', 'post_file', 'review_id',
    ];

    /**
     * Relationship one to many terhadap tabel posts
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Relationship one to many terhadap tabel reviews
     */
    public function review()
    {
        return $this->belongsTo('App\Review');
    }
}
