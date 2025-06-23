<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'client_id', 'representative_name', 'trade_name', 'total_building_area', 'number_of_occupant', 'type_of_occupancy', 'type_of_building', 'nature_of_business', 'BIN', 'TIN', 'DTI', 'SEC', 'high_rise', 'eminent_danger', 'address_brgy', 'address_ex', 'location_latitude', 'location_longitude', 'email', 'landline', 'contact_number'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function latestApplicationStatus()
    {
        return $this->hasOne(ApplicationStatus::class, 'application_id', 'id')->latest('updated_at');
    }

    public function hasApplication(): bool
    {
        return $this->applications()->exists();
    }

    public function latestApplication()
    {
        return $this->hasOne(Application::class)->latestOfMany();
    }
}
