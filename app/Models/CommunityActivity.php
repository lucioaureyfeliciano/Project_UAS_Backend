<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityActivity extends Model
{
    protected $fillable = [
        'community_id',
        'user_id',
        'action',
        'description',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
