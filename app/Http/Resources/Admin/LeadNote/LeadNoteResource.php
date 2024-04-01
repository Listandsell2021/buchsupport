<?php

namespace App\Http\Resources\Admin\LeadNote;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadNoteResource extends JsonResource
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
            'lead_id' => $this->lead_id,
	        'admin_id' => $this->admin_id,
            'salesperson_id' => $this->salesperson_id,
            'admin' => $this->admin_name,
            'salesperson' => $this->salesperson_name,
            'description' => $this->description,
            'type' => $this->type,
            'created_by' => $this->created_by,
	        'created_at' => $this->created_at,
	        'updated_at' => $this->updated_at
	    ];
    }
}
