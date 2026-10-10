
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblAcademicYears', function (Blueprint $table) {
            $table->id('academic_year_id');

            $table->string('academic_year', 20)->unique();

            $table->date('start_date');
            $table->date('end_date');

            // 1 = Active, 0 = Inactive
            $table->smallInteger('status')->default(1);

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblAcademicYears');
    }
};
