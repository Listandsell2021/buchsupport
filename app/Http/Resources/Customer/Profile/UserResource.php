<?php

namespace App\Http\Resources\Customer\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'uid' => $this->uid,
            'membership' => $this->membership,
	        'first_name' => $this->first_name,
	        'last_name' => $this->last_name,
	        'email' => $this->email,
	        'gender' => $this->gender,
	        'phone_no' => $this->phone_no,
	        'street' => $this->street,
	        'postal_code' => $this->postal_code,
	        'city' => $this->city,
	        'country' => $this->country,
	        'dob' => $this->dob ? getDateByLocale($this->dob) : null,
            'note' => $this->note,
            'image_path' => $this->image_path,
            'is_special' => $this->is_special,
            'secondary_first_name' => $this->secondary_first_name,
            'secondary_last_name' => $this->secondary_last_name,
	        'is_active' => $this->is_active,
            'auth_role' => 'customer',
	        'created_at' => date('d-m-Y H:i:s', strtotime($this->created_at)),
	        'updated_at' => date('d-m-Y H:i:s', strtotime($this->updated_at))
	    ];
    }
}
