<?php

namespace App\Http\Resources\Admin\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
	        'first_name' => $this->first_name,
	        'last_name' => $this->last_name,
            'fullname' => $this->first_name.' '. $this->last_name,
	        'email' => $this->email,
	        'dob' => $this->dob ? getDateByLocale($this->dob) : null,
            'password' => $this->password,
            'password_text' => $this->password_text,
            'gender' => $this->gender,
	        'phone_no' => $this->phone_no,
	        'street' => $this->street,
	        'postal_code' => $this->postal_code,
	        'city' => $this->city,
	        'country' => $this->country,
            'membership' => $this->membership,
            'secondary_first_name' => $this->secondary_first_name,
            'secondary_last_name' => $this->secondary_last_name,
            'is_special' => $this->is_special,
	        'is_active' => $this->is_active,
            'auto_invoice' => (boolean) $this->auto_invoice,
            'auto_invoice_date' => (int) $this->auto_invoice_date,
	        'created_at' => $this->created_at,
	        'updated_at' => $this->updated_at,
            'forms' => $this->forms,
            'contract' => $this->contract ?? null,
            'salesperson' => $this->salesperson ?? null,
	    ];
    }
}
