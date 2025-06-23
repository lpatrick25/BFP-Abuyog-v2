<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Application extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const OCCUPANCY = 0;
    const NEW_BUSINESS = 1;
    const RENEWAL_BUSINESS = 2;

    const FSIC_TYPE = [
        self::OCCUPANCY,
        self::NEW_BUSINESS,
        self::RENEWAL_BUSINESS,
    ];

    protected $fillable = ['application_number', 'establishment_id', 'fsic_type', 'application_date'];

    public $casts = [
        'application_date' => 'datetime'
    ];

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function applicationStatuses(): HasMany
    {
        return $this->hasMany(ApplicationStatus::class);
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function fsics(): HasMany
    {
        return $this->hasMany(Fsic::class);
    }

    public function latestStatus()
    {
        return $this->hasOne(ApplicationStatus::class)->latestOfMany();
    }

    public function previousStatus()
    {
        return $this->hasOne(ApplicationStatus::class)
            ->where('id', '<', optional($this->latestStatus)->id)
            ->latest('id');
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(200)
            ->height(200)
            ->optimize()
            ->performOnCollections('fsic_requirements');

        $this->addMediaConversion('web_thumbnail')
            ->width(360)
            ->height(360)
            ->optimize()
            ->performOnCollections('fsic_requirements');

        $this->addMediaConversion('responsive')
            ->height(720)
            ->width(720)
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('fsic_requirements');

        if ($media->mime_type === 'application/pdf') {
            $this->addMediaConversion('thumbnail')
                ->setManipulations(['format' => 'jpg'])
                ->page(1)
                ->width(300)
                ->height(400)
                ->performOnCollections('fsic_requirements');
        }
    }
}
