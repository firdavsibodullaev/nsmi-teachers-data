<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FacultyResource extends JsonResource
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
            'FullNameUz' => $this->FullNameUz,
            'FullNameOz' => $this->FullNameOz,
            'FullNameRu' => $this->FullNameRu,
            'ShortNameUz' => $this->ShortNameUz,
            'ShortNameOz' => $this->ShortNameOz,
            'ShortNameRu' => $this->ShortNameRu,
            'Departments' => DepartmentResource::collection($this->whenLoaded('departments'))
        ];
    }
}
