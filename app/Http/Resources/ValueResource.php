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
    public function toArray($request): array
    {
        $value = $this->Value;
        if ($this->field->Type === 'date') {
            $value = date('Y-m-d', strtotime($this->Value));
        }
        return [
            'Id' => $this->Id,
            'Value' => $value,
            'Field' => new FieldResource($this->field),
            'File' => $this->File ? asset("storage/files/{$this->File}") : null
        ];
    }
}
