<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'Id' => $this->Id,
            'Value' => $this->Value,
            'Field' => $this->field,
            'File' => $this->File ? asset("storage/files/{$this->File}") : null
        ];
    }
}
