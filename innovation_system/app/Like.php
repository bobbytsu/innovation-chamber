<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * Atribut yang dapat di  mass assignment
     */
    protected $fillable = [
        'user_id', 'post_id', 'upload_id', 'like',
    ];

    /**
     * Relationship one to many terhadap tabel users
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship one to many terhadap tabel posts
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Relationship one to many terhadap tabel uploads
     */
    public function upload()
    {
        return $this->belongsTo('App\Upload');
    }
}
