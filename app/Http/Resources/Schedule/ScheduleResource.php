<?php

namespace App\Http\Resources\Schedule;

use App\Http\Resources\Resource;

class ScheduleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'schedule_date' => $this->schedule_date,
            'establishment_name' => $this->application->establishment->name,
            'application_id' => $this->application->id,
            'application_number' => $this->application->application_number,
            'location_latitude' => $this->application->establishment->location_latitude,
            'location_longitude' => $this->application->establishment->location_longitude,
            'inspector' => $this->inspector->getFullName(),
            'status' => $this->status,
        ];
    }
}
