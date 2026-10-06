<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\ClassModel;

class ClassController extends Controller

{
    private function formatStudyDays(ClassModel $class): ?string
    {
        $days = $class->timetables
            ->sortBy(fn($timetable) => $timetable->day?->sort_order)
            ->pluck('day.day_code')
            ->filter()
            ->values()
            ->all();

        if (empty($days)) {
            return null;
        }

        return match ($days) {
            ['MON', 'TUE', 'WED', 'THU', 'FRI'] => 'Mon-Fri',
            ['MON', 'WED', 'FRI'] => 'Mon-Wed-Fri',
            ['TUE', 'THU'] => 'Tue-Thu',
            ['SAT', 'SUN'] => 'Sat-Sun',
            default => implode('-', array_map(
                fn($day) => ucfirst(strtolower($day)),
                $days
            )),
        };
    }
    public function available(Request $request): JsonResponse
    {
        $classes = ClassModel::query()
            ->where('status', 'Active')
            ->with([
                'course',
                'teacher',
                'room',
                'timeSlot',
                'timetables.day',
            ])
            ->orderBy('class_id', 'asc')
            ->get();



        return response()->json([
            'success' => true,

            'classes' => $classes->map(function ($class) {
                return [
                    'id' => $class->class_id,

                    'code' => $class->class_code,

                    'name' => $class->class_name,

                    'course' => $class->course?->course_name,

                    'teacher' => $class->teacher
                        ? trim(
                            $class->teacher->first_name_en . ' ' .
                                $class->teacher->last_name_en
                        )
                        : null,

                    'room' => $class->room?->room_name,

                    // 'study' => $class->timetables->isNotEmpty()
                    //     ? 'Mon-Fri'
                    //     : null,

                    'study' => $this->formatStudyDays($class),

                    'time' => $class->timeSlot
                        ? $class->timeSlot->start_time->format('H:i')
                        . ' - ' .
                        $class->timeSlot->end_time->format('H:i')
                        : null,

                    'price' => $class->course?->price,

                    'academic_year' => $class->academic_year,

                    'max_students' => $class->max_students,

                    'current_students' => $class->current_students,

                    'available_seats' => max(
                        0,
                        $class->max_students - $class->current_students
                    ),

                    'status' => $class->status,
                ];
            }),
        ]);
    }
}
