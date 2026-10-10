<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $years = [
            [
                'academic_year' => '2024-2025',
                'start_date' => '2024-11-01',
                'end_date' => '2025-10-31',
                'status' => 0,
            ],
            [
                'academic_year' => '2025-2026',
                'start_date' => '2025-11-01',
                'end_date' => '2026-10-31',
                'status' => 0,
            ],
            [
                'academic_year' => '2026-2027',
                'start_date' => '2026-11-01',
                'end_date' => '2027-10-31',
                'status' => 1,
            ],
        ];

        foreach ($years as $year) {
            AcademicYear::updateOrCreate(
                ['academic_year' => $year['academic_year']],
                [
                    'start_date' => $year['start_date'],
                    'end_date' => $year['end_date'],
                    'status' => $year['status'],
                    'created_by' => null,
                ]
            );
        }

        // Generate additional fake academic years
        for ($i = 0; $i < 5; $i++) {
            $startYear = $faker->numberBetween(2018, 2023);
            $academicYear = "{$startYear}-" . ($startYear + 1);

            AcademicYear::firstOrCreate(
                ['academic_year' => $academicYear],
                [
                    'start_date' => "{$startYear}-11-01",
                    'end_date' => ($startYear + 1) . '-10-31',
                    'status' => 0,
                    'created_by' => null,
                ]
            );
        }
    }
}
