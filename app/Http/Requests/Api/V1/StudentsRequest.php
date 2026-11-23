<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('id');

        return [
            'student_code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('tblStudents', 'student_code')
                    ->ignore($studentId, 'student_id'),
            ],
            'first_name_kh' => ['required', 'string', 'max:100'],
            'last_name_kh' => ['required', 'string', 'max:100'],
            'first_name_en' => ['required', 'string', 'max:100'],
            'last_name_en' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'string', 'in:Male,Female'],
            'dob' => ['required', 'date'],
            'phone1' => ['required', 'string', 'max:20'],
            'phone2' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'academic_year' => ['required', 'string', 'max:100'],
            'register_at' => ['nullable', 'date'],
            'guardian1_name' => ['required', 'string', 'max:150'],
            'guardian2_name' => ['required', 'string', 'max:150'],
            'guardian1_relationship' => ['required', 'string', 'max:150'],
            'guardian2_relationship' => ['required', 'string', 'max:150'],
            'guardian1_phone' => ['nullable', 'string', 'max:20'],
            'guardian2_phone' => ['nullable', 'string', 'max:20'],
            'guardian_email' => ['nullable', 'email', 'max:150'],
            'status' => [
                'sometimes',
                'string',
                Rule::in(['draft', 'active', 'inactive', '1', '0']),
            ],
        ];
    }
}
