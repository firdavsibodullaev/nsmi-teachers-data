<?php

namespace App\Http\Resources;

use App\Constants\FieldTypeConstants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
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
            'Type' => [
                'KeyName' => $this->Type,
                'Name' => FieldTypeConstants::translatedList()[$this->Type]
            ],
            'Tables' => TableResource::collection($this->whenLoaded('tables'))
        ];
    }
}
