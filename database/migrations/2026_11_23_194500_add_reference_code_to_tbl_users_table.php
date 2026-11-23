<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tblUsers', function (Blueprint $table) {
            $table->string('reference_code', 100)->nullable()->unique();
        });

        DB::table('tblUsers')
            ->whereNull('reference_code')
            ->orderBy('user_id')
            ->get(['user_id', 'reference_id', 'reference_type'])
            ->each(function ($user) {
                $referenceType = strtolower(
                    class_basename((string) $user->reference_type)
                );

                $referenceCode = match ($referenceType) {
                    'employee', 'employees' => DB::table('tblEmployees')
                        ->where('employee_id', $user->reference_id)
                        ->value('employee_code'),
                    'student', 'students' => DB::table('tblStudents')
                        ->where('student_id', $user->reference_id)
                        ->value('student_code'),
                    default => null,
                };

                if ($referenceCode !== null) {
                    DB::table('tblUsers')
                        ->where('user_id', $user->user_id)
                        ->update(['reference_code' => $referenceCode]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('tblUsers', function (Blueprint $table) {
            $table->dropColumn('reference_code');
        });
    }
};
