<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'quantity' => $this->quantity,
            'value' => new ValueResource($this->value),
            'product' => new ProductResource($this->product),
            'amount' => $this->quantity * $this->value->price . ' грн',
        ];
    }
}
