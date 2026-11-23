<?php

namespace Tests\Unit;

use App\Http\Resources\Api\V1\StudentResource;
use App\Models\ClassModel;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class StudentResourceTest extends TestCase
{
    public function test_it_serializes_student_enrollments_for_details(): void
    {
        $student = new Student();
        $student->setRawAttributes([
            'student_id' => 12,
            'student_code' => 'STU-00012',
            'first_name_en' => 'Dara',
            'last_name_en' => 'Sok',
            'status' => 'active',
        ]);

        $class = new ClassModel();
        $class->setRawAttributes([
            'class_id' => 4,
            'class_name' => 'English A',
        ]);

        $enrollment = new Enrollment();
        $enrollment->setRawAttributes([
            'enrollment_id' => 21,
            'class_id' => 4,
            'price' => '100.00',
            'discount' => '5.00',
        ]);
        $enrollment->setRelation('class', $class);
        $student->setRelation('enrollments', new Collection([$enrollment]));

        $data = (new StudentResource($student))->resolve(Request::create('/'));

        $this->assertSame(12, $data['student_id']);
        $this->assertSame('STU-00012', $data['student_code']);
        $this->assertSame([
            [
                'enrollment_id' => 21,
                'class_id' => 4,
                'class_name' => 'English A',
                'price' => '100.00',
                'discount' => '5.00',
            ],
        ], $data['enrollments']);
    }
}
