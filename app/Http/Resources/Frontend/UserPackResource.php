<?php

namespace App\Http\Resources\Frontend;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var $this User */
        $data = parent::toArray($request);
        $data['products'] = $this->products->take(10);

        return $data;
    }
}
