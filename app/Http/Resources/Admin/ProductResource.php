<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
	        'title' => $this->title,
	        'category_id' => $this->category_id,
	        'category' => $this->category_id ? $this->category->title : null,
	        'note' => $this->note,
	        'yt_link' => $this->yt_link,
	        'media' => ProductMediaResource::collection($this->media),
	        'created_at' => $this->created_at,
	        'updated_at' => $this->updated_at
	    ];
    }
}
