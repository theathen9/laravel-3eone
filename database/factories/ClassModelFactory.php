<?php

namespace Database\Factories;

use App\Models\ClassModel;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassModelFactory extends Factory
{
    protected $model = ClassModel::class;

    public function definition(): array
    {
        return [
            'class_name' => fake()->randomElement([
                'English Beginner A',
                'English Beginner B',
                'English Intermediate A',
                'English Intermediate B',
                'English Advanced A',
                'English Advanced B',
            ]),

            'class_code' => strtoupper(
                fake()->unique()->bothify('CLS-####')
            ),

            'course_id' => Course::factory(),

            'academic_year' => fake()->randomElement([
                '2025-2026',
                '2026-2027',
                '2027-2028',
            ]),

            'max_students' => fake()->randomElement([
                20,
                25,
                30,
                40,
                50,
            ]),

            'current_students' => 0,

            'status' => 'Active',

            'teacher_id' => null,

            'room_id' => null,

            'slot_id' => null,
        ];
    }
}
