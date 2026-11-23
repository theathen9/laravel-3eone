<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class EmployeesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('position')) {
            $this->merge([
                'position_id' => $this->input('position'),
            ]);
        }
    }

    public function rules(): array
    {
        return [

            'employee_id' => [
                'required',
                'integer',
                'min:1',
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

            'position_id' => [
                'nullable',
                'integer',
                'exists:tblPositions,position_id',
            ],

            'branch_id' => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                'nullable',
                'integer',
                'exists:tblBranches,branch_id',
            ],

            'birth_addr_province' => ['nullable', 'string', 'max:100'],
            'birth_addr_district' => ['nullable', 'string', 'max:100'],
            'birth_addr_commune' => ['nullable', 'string', 'max:100'],
            'birth_addr_village' => ['nullable', 'string', 'max:100'],

            'curr_addr_province' => ['nullable', 'string', 'max:100'],
            'curr_addr_district' => ['nullable', 'string', 'max:100'],
            'curr_addr_commune' => ['nullable', 'string', 'max:100'],
            'curr_addr_village' => ['nullable', 'string', 'max:100'],
            'hired_at' => [
                'required',
                'string',
                'max:20',
            ],
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'signature_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'created_by' => [
                'nullable',
                'string',
                'max:100',
            ],

            'status' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
