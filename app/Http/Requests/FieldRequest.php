<?php

namespace App\Http\Requests;

use App\Constants\FieldTypeConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FieldRequest extends FormRequest
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
        return $this->getRoles();
    }

    public function getRoles(): array
    {
        if ($this->isMethod('post')) {
            return [
                'FullName' => 'required|string|max:255|unique:fields,FullName',
                'ShortName' => 'required|string|max:50|unique:fields,ShortName',
                'Type' => ['nullable', 'string', Rule::in(FieldTypeConstants::list())]
            ];
        }
        $fieldId = $this->route('field')->Id;

        return [
            'FullName' => "required|string|max:255|unique:fields,FullName,{$fieldId},Id",
            'ShortName' => "required|string|max:50|unique:fields,ShortName,{$fieldId},Id",
            'Type' => ['nullable', 'string', Rule::in(FieldTypeConstants::list())]
        ];
    }
}
