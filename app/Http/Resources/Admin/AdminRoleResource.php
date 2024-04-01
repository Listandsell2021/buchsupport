<?php

namespace App\Http\Resources\Admin;

use App\DataHolders\Enum\AdminRole;
use App\DataHolders\Enum\AuthRole;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminRoleResource extends JsonResource
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
	        'dob' => $this->dob ? date('Y-m-d',strtotime($this->dob)) : null,
	        'phone_no' => $this->phone_no,
	        'gender' => $this->gender,
	        'street' => $this->street,
	        'postal_code' => $this->postal_code,
	        'city' => $this->city,
	        'country' => $this->country,
	        'role_id' => $this->role_id,
	        'auth_role' => $this->auth_role,
            'admin_role' => $this->role_id == 1 ? AdminRole::admin->value : AdminRole::employee->value,
	        'is_active' => $this->is_active,
	        'created_at' => $this->created_at,
	        'updated_at' => $this->updated_at,
            'permissions' => $this->permissions->pluck('permission')->toArray(),
            'lead_table_columns' => $this->lead_columns ? json_decode($this->lead_columns) : null,
	    ];
    }
}
