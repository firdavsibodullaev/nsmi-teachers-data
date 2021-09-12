<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'Id' => $this->Id,
            'FullName' => $this->FullName,
            'ShortName' => $this->ShortName,
            'Fields' => FieldResource::collection($this->whenLoaded('fields')),
        ];
    }
}
