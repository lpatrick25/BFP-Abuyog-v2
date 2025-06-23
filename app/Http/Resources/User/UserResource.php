<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->getFullName(),
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'extension_name' => $this->extension_name,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'user_id' => $this->user_id,
        ];
    }
}
