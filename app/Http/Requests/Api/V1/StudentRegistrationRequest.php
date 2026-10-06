<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StudentRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'step' => [
                'required',
                'integer',
                'between:1,3',
            ],

            'student_id' => [
                'required',
                'integer',
                'min:1',
            ],

            'student_code' => [
                'nullable',
                'string',
                'max:100',
            ],

            'first_name_kh' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name_kh' => [
                'required',
                'string',
                'max:100',
            ],

            'first_name_en' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name_en' => [
                'required',
                'string',
                'max:100',
            ],

            'gender' => [
                'required',
                'string',
                'in:Male,Female',
            ],

            'dob' => [
                'required',
                'date',
            ],

            'academic_year' => [
                'required',
                'string',
                'max:100',
            ],

            'register_at' => [
                'nullable',
                'date',
            ],

            'phone1' => [
                'required',
                'string',
                'max:20',
            ],

            'phone2' => [
                'nullable',
                'string',
                'max:20',
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'profile_image' => [
                'nullable',
                'image',
                'max:2048',
            ],

            'birth_addr_province' => ['nullable', 'string', 'max:100'],
            'birth_addr_district' => ['nullable', 'string', 'max:100'],
            'birth_addr_commune' => ['nullable', 'string', 'max:100'],
            'birth_addr_village' => ['nullable', 'string', 'max:100'],

            'curr_addr_province' => ['nullable', 'string', 'max:100'],
            'curr_addr_district' => ['nullable', 'string', 'max:100'],
            'curr_addr_commune' => ['nullable', 'string', 'max:100'],
            'curr_addr_village' => ['nullable', 'string', 'max:100'],

            'guardian1_name_first' => [
                'required',
                'string',
                'max:100',
            ],

            'guardian1_name_last' => [
                'required',
                'string',
                'max:100',
            ],

            'guardian2_name_first' => [
                'required',
                'string',
                'max:100',
            ],

            'guardian2_name_last' => [
                'required',
                'string',
                'max:100',
            ],

            'guardian1_relationship' => [
                'required',
                'string',
                'max:100',
            ],

            'guardian2_relationship' => [
                'nullable',
                'string',
                'max:100',
            ],

            'guardian_curr_addr_village' => [
                'nullable',
                'string',
                'max:100',
            ],

            'guardian_curr_addr_commune' => [
                'nullable',
                'string',
                'max:100',
            ],

            'guardian_curr_addr_district' => [
                'nullable',
                'string',
                'max:100',
            ],

            'guardian_curr_addr_province' => [
                'nullable',
                'string',
                'max:100',
            ],

            'guardian1_phone' => [
                'nullable',
                'string',
                'max:100',
            ],

            'guardian2_phone' => [
                'nullable',
                'string',
                'max:100',
            ],

            'guardian_email' => [
                'nullable',
                'email',
                'max:100',
            ],

            'created_by' => [
                'nullable',
                'string',
                'max:100',
            ],

            'class_ids' => [
                'nullable',
                'array',
            ],

            'class_ids.*' => [
                'integer',
                'exists:tblClasses,class_id',
            ],

            'payment_method_id' => [
                'nullable',
                'integer',
                'exists:tblPaymentMethods,method_id',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'amount_paid' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ];
    }
}
