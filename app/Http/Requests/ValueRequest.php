<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValueRequest extends FormRequest
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

    /**
     * @return string[]
     */
    protected function getRules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'TableId' => 'required|integer|exists:tables,Id',
                'Values' => 'required|array',
                'Values.*' => 'required|array',
                'Values.*.File' => 'nullable|file',
                'Values.*.Value' => 'string|required|max:1000',
                'Values.*.FieldId' => 'integer|required|exists:fields,Id'
            ];
        }
        return [
            'Values' => 'required|array',
            'Values.*' => 'required|array',
            'Values.*.File' => 'nullable|file',
            'Values.*.Value' => 'string|required|max:1000',
            'Values.*.FieldId' => 'integer|required|exists:fields,Id'
        ];
    }
}
