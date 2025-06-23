<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $fillable = ['endpoint', 'keys'];

    protected $casts = [
        'keys' => 'array',  // To store the keys as an array.
    ];
}
