<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PositionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $positionId = $this->route('id');

        return [
            'position_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tblPositions', 'position_code')
                    ->ignore($positionId, 'position_id'),
            ],
            'position_name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'status' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
