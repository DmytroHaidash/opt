<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'has_pickup' => $this->has_pickup,
            'delivery' => $this->has_delivery ? __('shop.delivery_from', ['city' => $this->user->city->name]) : 0,
            'src' => $this->thumb
        ];
    }
}
