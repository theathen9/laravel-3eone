<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RoomsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_name' => [
                'required',
                'string',
                'max:50',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],
            'status' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}
