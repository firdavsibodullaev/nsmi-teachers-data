<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
            'Values' => ValueResource::collection($this->values),
            'User' => new UserResource($this->user),
            'Table' => new TableResource($this->whenLoaded('table'))
        ];
    }
}