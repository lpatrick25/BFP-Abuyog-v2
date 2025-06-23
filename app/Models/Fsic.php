<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Fsic extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['fsic_no', 'application_id', 'issue_date', 'expiration_date', 'amount', 'or_number', 'payment_date', 'inspector_id', 'marshall_id'];

    protected $casts = [
        'issue_date' => 'datetime',
        'expiration_date' => 'datetime',
        'payment_date' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Inspector::class);
    }

    public function marshall(): BelongsTo
    {
        return $this->belongsTo(Marshall::class);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiration_date->isPast();
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(200)
            ->height(200)
            ->optimize()
            ->performOnCollections('fsic_certificates');

        $this->addMediaConversion('web_thumbnail')
            ->width(360)
            ->height(360)
            ->optimize()
            ->performOnCollections('fsic_certificates');

        $this->addMediaConversion('responsive')
            ->height(720)
            ->width(720)
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('fsic_certificates');

        $this->addMediaCollection('fsic_certificates')
            ->singleFile()
            ->acceptsMimeTypes(['text/html']);
    }
}
