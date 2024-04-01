<?php

namespace App\Http\Resources\Admin\Product;

use App\Libraries\Services\ProductImageManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
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
	        'name' => $this->name,
	        'image_path' => $this->image_path,
            'image_url' => ProductImageManager::getImageUrl($this->image_path),
            'thumb_url' => ProductImageManager::getThumbUrl($this->image_path),
            'web_url' => ProductImageManager::getWebUrl($this->image_path),
	        'order_no' => $this->order_no,
	        'created_at' => $this->created_at,
	        'updated_at' => $this->updated_at
	    ];
    }

}
