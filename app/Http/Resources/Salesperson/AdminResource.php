<?php

namespace App\Http\Resources\Salesperson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
	        'email' => $this->email,
	        'dob' => $this->dob ? getDateByLocale($this->dob) : null,
	        'phone_no' => $this->phone_no,
	        'gender' => $this->gender,
	        'street' => $this->street,
	        'postal_code' => $this->postal_code,
	        'city' => $this->city,
	        'country' => $this->country,
	        'is_active' => $this->is_active,
	        'created_at' => date('d-m-Y H:i:s', strtotime($this->created_at)),
	        'updated_at' => date('d-m-Y H:i:s', strtotime($this->updated_at))
	    ];
    }
}
