<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblStudents', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('student_id')->unique();


            $table->string('student_code', 100)->unique()->nullable();

            $table->string('first_name_kh', 100);
            $table->string('last_name_kh', 100);

            $table->string('first_name_en', 100);
            $table->string('last_name_en', 100);

            $table->string('gender', 20);
            $table->date('dob');

            $table->string('birth_addr_village', 100);
            $table->string('birth_addr_commune', 100);
            $table->string('birth_addr_district', 100);
            $table->string('birth_addr_province', 100);

            $table->string('curr_addr_village', 100);
            $table->string('curr_addr_commune', 100);
            $table->string('curr_addr_district', 100);
            $table->string('curr_addr_province', 100);

            $table->string('phone1', 20);
            $table->string('phone2', 20)->nullable();

            $table->string('email', 150)->nullable();

            $table->string('profile_image', 255)->nullable();

            $table->string('academic_year', 100);
            $table->date('register_at')->nullable();

            $table->string('guardian1_name', 150);
            $table->string('guardian2_name', 150);

            $table->string('guardian1_relationship', 150);
            $table->string('guardian2_relationship', 150);

            $table->string('guardian_curr_addr_village', 100);
            $table->string('guardian_curr_addr_commune', 100);
            $table->string('guardian_curr_addr_district', 100);
            $table->string('guardian_curr_addr_province', 100);

            $table->string('guardian1_phone', 20)->nullable();
            $table->string('guardian2_phone', 20)->nullable();

            $table->string('guardian_email', 150)->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->unsignedBigInteger('created_by')->nullable();

            $table->string('status', 20)->default('draft');

            $table->foreign('created_by', 'fk_student_creator')
                ->references('employee_id')
                ->on('tblEmployees')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblStudents');
    }
};
