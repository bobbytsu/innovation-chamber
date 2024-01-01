<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Upload extends Model
{
    /**
     * Atribut yang dapat di mass assignment
     */
    protected $fillable = [
        'user_id', 'upload_video', 'title', 'description', 'thumbnail',
    ];

    /**
     * Relationship one to many terhadap tabel users
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship one to many terhadap tabel likes
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    /**
     * Memeriksa apakah pengguna telah melakukan like terhadap sebuah Upload
     */
    public function isAuthUserLikedUpload(){
        $like = $this->likes()->where('user_id',  Auth::user()->id)->get();
        if ($like->isEmpty()){
            return false;
        }
        return true;
    }

    /**
     * Relationship one to many terhadap tabel comments
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}