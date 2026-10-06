<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Level;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'course_code' => fake()->unique()->bothify('CRS-####'),

            'course_name' => fake()->randomElement([
                'General English',
                'English Beginner',
                'English Intermediate',
                'English Advanced',
                'Business English',
                'Academic English',
                'Communication English',
            ]),

            'subject_id' => Subject::query()->inRandomOrder()->value('subject_id')
                ?? Subject::factory(),

            'level_id' => Level::query()->inRandomOrder()->value('level_id')
                ?? Level::factory(),

            'price' => fake()->randomElement([
                25.00,
                30.00,
                35.00,
                40.00,
                45.00,
                50.00,
                60.00,
                75.00,
                100.00,
            ]),

            'duration' => fake()->randomElement([
                '3 Months',
                '6 Months',
                '9 Months',
                '12 Months',
            ]),
        ];
    }
}
