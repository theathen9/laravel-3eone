<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblEmployees', function (Blueprint $table) {
            $table->id('employee_id');

            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();

            // Khmer name
            $table->string('first_name_kh', 100);
            $table->string('last_name_kh', 100);

            // English name
            $table->string('first_name_en', 100);
            $table->string('last_name_en', 100);

            $table->string('gender', 20);
            $table->date('dob');

            // Birth address
            $table->string('birth_addr_village', 100);
            $table->string('birth_addr_commune', 100);
            $table->string('birth_addr_district', 100);
            $table->string('birth_addr_province', 100);

            // Current address
            $table->string('curr_addr_village', 100);
            $table->string('curr_addr_commune', 100);
            $table->string('curr_addr_district', 100);
            $table->string('curr_addr_province', 100);

            // Contact
            $table->string('phone1', 20);
            $table->string('phone2', 20)->nullable();

            $table->string('email', 150)->unique()->nullable();

            // Profile
            $table->string('profile_image', 255)->nullable();

            $table->date('hired_at');

            // 0, 1, 2, 3...
            $table->smallInteger('status')->default(1);

            $table->timestamp('created_at')->useCurrent();

            // Foreign keys
            $table->foreign('department_id')
                ->references('department_id')
                ->on('tblDepartments')
                ->nullOnDelete();

            $table->foreign('position_id')
                ->references('position_id')
                ->on('tblPositions')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblEmployees');
    }
};
