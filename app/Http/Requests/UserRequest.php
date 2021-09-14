<?php

namespace App\Http\Requests;

use App\Constants\PostConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
                'FirstName' => 'required|string|max:255',
                'LastName' => 'required|string|max:255',
                'Patronymic' => 'nullable|string|max:255',
                'Username' => 'required|string|max:255|min:5|unique:users,Username',
                'Password' => [
                    'required',
                    'confirmed',
                    'string',
                    'max:255',
                    'min:6',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[_@$!%*#?&]/',
                ],
                'Birth' => 'nullable|date|before:yesterday',
                'Phone' => [
                    'nullable',
                    'regex:/^998[\d]{9}$/',
                    'unique:users,Phone'
                ],
                'FacultyId' => 'nullable|integer|exists:faculties,Id',
                'DepartmentId' => 'nullable|integer|exists:departments,Id',
                'Post' => [
                    'required',
                    Rule::in(PostConstants::list()),
                ],
                'Email' => 'nullable|string|email|unique:users,Email',
                'Photo' => 'nullable|file|mimes:jpg,png|max:10240'
            ];
        }
        $userId = $this->route('user')->Id;
        return [
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Patronymic' => 'nullable|string|max:255',
            'Username' => "required|string|max:255|min:5|unique:users,Username,{$userId},Id",
            'Password' => [
                'nullable',
                'confirmed',
                'string',
                'max:255',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[_@$!%*#?&]/',
            ],
            'Birth' => 'nullable|date|before:yesterday',
            'Phone' => [
                'nullable',
                'regex:/^998[\d]{9}$/',
                "unique:users,Phone,{$userId},Id"
            ],
            'FacultyId' => 'nullable|integer|exists:faculties,Id',
            'DepartmentId' => 'nullable|integer|exists:departments,Id',
            'Post' => [
                'required',
                Rule::in(PostConstants::list()),
            ],
            'Email' => "nullable|string|email|unique:users,Email,{$userId},Id",
            'Photo' => 'nullable|file|mimes:jpg,png|max:10240'
        ];
    }
}
