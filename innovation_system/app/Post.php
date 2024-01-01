<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Post extends Model
{
    /**
     * Atribut yang dapat di mass assignment
     */
    protected $fillable = [
        'user_id', 'category_id', 'season', 'contributor', 'stage1_id', 'stage2_id', 'stage3_id', 'stage4_id', 'stage5_id',
    ];

    /**
     * Relationship one to many terhadap tabel users
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship one to many terhadap tabel categories
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Relationship one to many terhadap tabel stage1s
     */
    public function stage1()
    {
        return $this->belongsTo('App\Stage1');
    }

    /**
     * Relationship one to many terhadap tabel stage2s
     */
    public function stage2()
    {
        return $this->belongsTo('App\Stage2');
    }

    /**
     * Relationship one to many terhadap tabel stage3s
     */
    public function stage3()
    {
        return $this->belongsTo('App\Stage3');
    }

    /**
     * Relationship one to many terhadap tabel stage4s
     */
    public function stage4()
    {
        return $this->belongsTo('App\Stage4');
    }

    /**
     * Relationship one to many terhadap tabel stage5s
     */
    public function stage5()
    {
        return $this->belongsTo('App\Stage5');
    }

    /**
     * Relationship one to many terhadap tabel likes
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    /**
     * Memeriksa apakah pengguna telah melakukan like terhadap sebuah posts
     */
    public function isAuthUserLikedPost(){
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