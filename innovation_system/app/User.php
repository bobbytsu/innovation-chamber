<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit_id', 'employeeid', 'profile_img', 'role', 'name', 'bio', 'phonenumber',  'email', 'password', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship one to many terhadap tabel units
     */
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    /**
     * Relationship one to many terhadap tabel events
     */
    public function events()
    {
        return $this->hasMany('App\Event');
    }
    
    /**
     * Relationship one to many terhadap tabel posts
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Relationship one to many terhadap tabel uploads
     */
    public function uploads()
    {
        return $this->hasMany('App\Upload');
    }

    /**
     * Relationship one to many terhadap tabel likes
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    /**
     * Relationship one to many terhadap tabel comments
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}