<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the branch into the API response shape.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'branch_id' => $this->branch_id,
            'branch_code' => $this->branch_code,
            'branch_name' => $this->branch_name,
            'phones' => $this->phones ?? [],
            'email' => $this->email,
            'address' => $this->address,
            'location' => $this->location,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'histories' => $this->whenLoaded('histories'),
        ];
    }
}
