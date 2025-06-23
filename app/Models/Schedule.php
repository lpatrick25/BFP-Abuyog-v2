<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'inspector_id', 'schedule_date', 'status'];

    protected $casts = [
        'schedule_date' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Inspector::class);
    }
}
