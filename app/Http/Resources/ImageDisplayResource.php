<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageDisplayResource extends JsonResource
{
    private $conversation;

    public function __construct($resource, $conversation = null)
    {
        parent::__construct($resource);
        $this->conversation = $conversation;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'src' => $this->conversation ? $this->getFullUrl($this->conversation) : $this->getFullUrl()
        ];
    }
}
