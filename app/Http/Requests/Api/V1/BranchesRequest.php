<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $branchId = $this->route('id');

        return [
            'branch_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tblBranches', 'branch_code')
                    ->ignore($branchId, 'branch_id'),
            ],

            'branch_name' => [
                'required',
                'string',
                'max:255',
            ],

            'phones' => [
                'sometimes',
                'array',
                'max:2',
            ],
            'phones.*' => [
                'required',
                'array',
            ],
            'phones.*.number' => [
                'required',
                'string',
                'max:30',
            ],
            'phones.*.label' => [
                'required',
                'string',
                'max:50',
                Rule::in(['Main', 'Alternate']),
                'distinct:strict',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'location' => [
                'nullable',
                'string',
                'max:500',
            ],

            'status' => [
                'sometimes',
                'boolean',
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'branch_code.required' => 'Branch code is required.',
            'branch_code.unique' => 'This branch code already exists.',
            'branch_name.required' => 'Branch name is required.',
            'email.email' => 'Please provide a valid email address.',
            'status.boolean' => 'Branch status must be true or false.',
        ];
    }
}
