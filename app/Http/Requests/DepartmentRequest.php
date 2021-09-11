<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
        $facultyId = $this->input('FacultyId');
        if ($this->isMethod('post')) {
            return [
                'FullNameUz' => 'required|unique:departments,FullNameUz|max:255',
                'FullNameOz' => 'required|unique:departments,FullNameOz|max:255',
                'FullNameRu' => 'required|unique:departments,FullNameRu|max:255',
                'ShortNameUz' => 'required|unique:departments,ShortNameUz|max:50',
                'ShortNameOz' => 'required|unique:departments,ShortNameOz|max:50',
                'ShortNameRu' => 'required|unique:departments,ShortNameRu|max:50',
                'FacultyId' => "required|integer|exists:faculties,Id",
            ];
        }
        $departmentId = $this->route('department')->Id;
        return [
            'FullNameUz' => "required|unique:departments,FullNameUz,{$departmentId},Id|max:255",
            'FullNameOz' => "required|unique:departments,FullNameOz,{$departmentId},Id|max:255",
            'FullNameRu' => "required|unique:departments,FullNameRu,{$departmentId},Id|max:255",
            'ShortNameUz' => "required|unique:departments,ShortNameUz,{$departmentId},Id|max:50",
            'ShortNameOz' => "required|unique:departments,ShortNameOz,{$departmentId},Id|max:50",
            'ShortNameRu' => "required|unique:departments,ShortNameRu,{$departmentId},Id|max:50",
            'FacultyId' => "required|integer|exists:faculties,Id",
        ];
    }
}
