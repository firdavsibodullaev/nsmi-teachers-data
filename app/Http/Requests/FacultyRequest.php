<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacultyRequest extends FormRequest
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
                'FullNameUz' => 'required|unique:faculties,FullNameUz|max:255',
                'FullNameOz' => 'required|unique:faculties,FullNameOz|max:255',
                'FullNameRu' => 'required|unique:faculties,FullNameRu|max:255',
                'ShortNameUz' => 'required|unique:faculties,ShortNameUz|max:50',
                'ShortNameOz' => 'required|unique:faculties,ShortNameOz|max:50',
                'ShortNameRu' => 'required|unique:faculties,ShortNameRu|max:50',
            ];
        }
        $facultyId = $this->route('faculty')->Id;
        return [
            'FullNameUz' => "required|unique:faculties,FullNameUz,{$facultyId},Id|max:255",
            'FullNameOz' => "required|unique:faculties,FullNameOz,{$facultyId},Id|max:255",
            'FullNameRu' => "required|unique:faculties,FullNameRu,{$facultyId},Id|max:255",
            'ShortNameUz' => "required|unique:faculties,ShortNameUz,{$facultyId},Id|max:50",
            'ShortNameOz' => "required|unique:faculties,ShortNameOz,{$facultyId},Id|max:50",
            'ShortNameRu' => "required|unique:faculties,ShortNameRu,{$facultyId},Id|max:50",
        ];
    }
}
