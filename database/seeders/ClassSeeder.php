<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use App\Models\Course;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();

        if ($courses->isEmpty()) {
            $this->command->warn(
                'No courses found. Please run CourseSeeder first.'
            );

            return;
        }

        foreach ($courses as $course) {
            ClassModel::factory()
                ->count(2)
                ->create([
                    'course_id' => $course->course_id,
                    'class_name' => $course->course_name . ' Class',
                ]);
        }

        $this->command->info(
            'Classes seeded successfully.'
        );
    }
}
