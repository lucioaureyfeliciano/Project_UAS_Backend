<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    protected $fillable = [
        'feature',
        'total',
    ];
}