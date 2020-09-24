<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductValue extends JsonResource
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
            'unit' => $this->unit_id,
            'price' => $this->price,
            'step' => $this->step,
            'min' => $this->min,
            'max' => $this->max,
            'discount' => $this->discount,
        ];
    }
}
