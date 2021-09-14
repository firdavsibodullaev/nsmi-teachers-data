<?php

namespace App\Http\Resources;

use App\Constants\PostConstants;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'Id' => $this->Id,
            'FirstName' => $this->FirstName,
            'LastName' => $this->LastName,
            'Patronymic' => $this->Patronymic,
            'Username' => $this->Username,
            'Phone' => $this->Phone,
            'Email' => $this->Email,
            'Birth' => $this->Birth,
            'Faculty' => new FacultyResource($this->whenLoaded('faculty')),
            'Department' => new FacultyResource($this->whenLoaded('department')),
            'Post' => [
                'KeyName' => $this->Post,
                'Name' => PostConstants::translatedList()[$this->Post]
            ],
            'Photo' => $this->Photo,
        ];
    }
}
