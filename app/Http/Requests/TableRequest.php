<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->getRules();
    }

    private function getRules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'FullName' => 'required|string|max:255|unique:tables,FullName',
                'ShortName' => 'required|string|max:50|unique:tables,ShortName',
                'Fields' => 'array|required',
                'Fields.*' => 'integer|exists:fields,Id'
            ];
        }
        $tableId = $this->route('table')->Id;
        return [
            'FullName' => "required|string|max:255|unique:tables,FullName,{$tableId},Id",
            'ShortName' => "required|string|max:50|unique:tables,ShortName,{$tableId},Id",
            'Fields' => 'array|required',
            'Fields.*' => 'integer|exists:fields,Id'
        ];
    }
}
