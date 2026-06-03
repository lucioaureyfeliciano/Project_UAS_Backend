<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function tweets()
    {
        return $this->belongsToMany(
            Tweet::class,
            'tweet_hashtags'
        );
    }
}