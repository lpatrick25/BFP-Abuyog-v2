<?php

namespace App\Models;

use App\Traits\HasFullName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes, HasFullName;

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'extension_name', 'contact_number', 'email', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class);
    }
}
