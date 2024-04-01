<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalespersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
	        'id' => $this->id,
	        'first_name' => $this->first_name,
	        'last_name' => $this->last_name,
            'fullname' => $this->first_name.' '. $this->last_name,
	        'email' => $this->email,
	        'dob' => $this->dob ? getDateByLocale($this->dob) : null,
            'gender' => $this->gender,
	        'phone_no' => $this->phone_no,
	        'street' => $this->street,
	        'postal_code' => $this->postal_code,
	        'city' => $this->city,
	        'country' => $this->country,
	        'is_active' => $this->is_active,
            'auth_role' => $this->auth_role,
            'role_id'   => $this->role_id,
	        'created_at' => $this->created_at,
	        'updated_at' => $this->updated_at
	    ];
    }
}
