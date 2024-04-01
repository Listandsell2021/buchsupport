<?php

namespace App\Http\Resources\Admin\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithImagesResource extends JsonResource
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
	        'name' => $this->name,
	        'category_id' => $this->category_id,
	        'category_name' => $this->category_id ? $this->category->name : '',
	        'description' => $this->description,
            'youtube_link' => $this->youtube_link,
            'images' => ProductImageResource::collection($this->images),
	        'created_at' => $this->created_at,
	        'updated_at' => $this->updated_at
	    ];
    }
}
