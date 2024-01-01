<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * Atribut yang dapat di mass assignment
     */
    protected $fillable = [
        'switch', 'status', 'reviewerid', 'reviewername', 'reviewerunit',
    ];

    /**
     * Relationship one to many terhadap tabel stage1s
     */
    public function stage1s()
    {
        return $this->hasMany('App\Stage1');
    }

    /**
     * Relationship one to many terhadap tabel stage2s
     */
    public function stage2s()
    {
        return $this->hasMany('App\Stage2');
    }

    /**
     * Relationship one to many terhadap tabel stage3s
     */
    public function stage3s()
    {
        return $this->hasMany('App\Stage3');
    }

    /**
     * Relationship one to many terhadap tabel stage4s
     */
    public function stage4s()
    {
        return $this->hasMany('App\Stage4');
    }

    /**
     * Relationship one to many terhadap tabel stage5s
     */
    public function stage5s()
    {
        return $this->hasMany('App\Stage5');
    }
}
