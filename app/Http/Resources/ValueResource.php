<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ValueResource extends JsonResource
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
            'price' => $this->price . ' грн',
            'min' => $this->min,
            'max' => $this->max ?? 100 ** 100,
            'step' => $this->step,
            'unit' => $this->unit->name
        ];
    }
}
