<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product' => $this->product->title,
            'unit' => $this->value->unit->name,
            'price' => $this->value->price,
            'quantity' => $this->quantity,
            'total' => $this->value->price * $this->quantity,
            'seller' => [
                'name' => $this->product->user->name,
                'city' => optional($this->product->city)->name,
                'region' => optional($this->product->city)->region->name,
                'phone' => $this->product->user->phone
            ],
            'address' => $this->product->address
        ];
    }
}
