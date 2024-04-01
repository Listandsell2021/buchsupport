<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductMediaResource extends JsonResource
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
	        'product_id' => $this->product_id,
	        'media_path' => $this->media_path,
	        'name' => $this->name,
	        'order_no' => $this->order_no,
	        'created_at' => $this->created_at,
	        'updated_at' => $this->updated_at
	    ];
    }
}
