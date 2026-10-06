<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimetableSeeder extends Seeder
{
    public function run(): void
    {
        $classes = DB::table('tblClasses')
            ->pluck('class_id');

        $days = DB::table('tblDays')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->pluck('day_id');

        if ($classes->isEmpty() || $days->isEmpty()) {
            return;
        }

        foreach ($classes as $classId) {

            // Random study pattern
            $patterns = [
                [1, 2, 3, 4, 5], // Mon-Fri
                [1, 3, 5],       // Mon-Wed-Fri
                [2, 4],          // Tue-Thu
                [1, 2, 4, 5],    // Mon-Tue-Thu-Fri
                [6, 7],          // Sat-Sun
                [6],             // Saturday
            ];

            $pattern = fake()->randomElement($patterns);

            foreach ($pattern as $dayNumber) {

                // day_id follows sort_order: 1=MON, 2=TUE, etc.
                $day = DB::table('tblDays')
                    ->where('sort_order', $dayNumber)
                    ->where('is_active', true)
                    ->first();

                if (!$day) {
                    continue;
                }

                DB::table('tblTimetables')->updateOrInsert(
                    [
                        'class_id' => $classId,
                        'day_id' => $day->day_id,
                    ],
                    [
                        'created_at' => now(),
                    ]
                );
            }
        }
    }
}
