<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student_id' => $this->student_id,
            'student_code' => $this->student_code,
            'first_name_kh' => $this->first_name_kh,
            'last_name_kh' => $this->last_name_kh,
            'first_name_en' => $this->first_name_en,
            'last_name_en' => $this->last_name_en,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'email' => $this->email,
            'profile_image' => $this->profile_image,
            'birth_addr_village' => $this->birth_addr_village,
            'birth_addr_commune' => $this->birth_addr_commune,
            'birth_addr_district' => $this->birth_addr_district,
            'birth_addr_province' => $this->birth_addr_province,
            'curr_addr_village' => $this->curr_addr_village,
            'curr_addr_commune' => $this->curr_addr_commune,
            'curr_addr_district' => $this->curr_addr_district,
            'curr_addr_province' => $this->curr_addr_province,
            'academic_year' => $this->academic_year,
            'register_at' => $this->register_at,
            'guardian1_name' => $this->guardian1_name,
            'guardian2_name' => $this->guardian2_name,
            'guardian1_relationship' => $this->guardian1_relationship,
            'guardian2_relationship' => $this->guardian2_relationship,
            'guardian_curr_addr_village' => $this->guardian_curr_addr_village,
            'guardian_curr_addr_commune' => $this->guardian_curr_addr_commune,
            'guardian_curr_addr_district' => $this->guardian_curr_addr_district,
            'guardian_curr_addr_province' => $this->guardian_curr_addr_province,
            'guardian1_phone' => $this->guardian1_phone,
            'guardian2_phone' => $this->guardian2_phone,
            'guardian_email' => $this->guardian_email,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'enrollments' => $this->whenLoaded(
                'enrollments',
                fn () => $this->enrollments->map(fn ($enrollment) => [
                    'enrollment_id' => $enrollment->enrollment_id,
                    'class_id' => $enrollment->class_id,
                    'class_name' => $enrollment->class?->class_name,
                    'price' => $enrollment->price,
                    'discount' => $enrollment->discount,
                ])->values()->all()
            ),
        ];
    }
}
