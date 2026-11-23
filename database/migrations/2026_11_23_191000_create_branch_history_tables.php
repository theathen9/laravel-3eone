<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblBranchHistory', function (Blueprint $table) {
            $table->id('branch_history_id');
            // Keep audit snapshots after the branch itself is deleted.
            $table->unsignedBigInteger('branch_id')->index();
            $table->string('action', 20);
            $table->string('branch_code', 50);
            $table->string('branch_name', 255);
            $table->json('phones')->nullable();
            $table->string('email', 255)->nullable();
            $table->text('address')->nullable();
            $table->text('location')->nullable();
            $table->smallInteger('status');
            $table->timestamp('recorded_at')->useCurrent();
        });

        Schema::create('tblEmployeeBranchHistory', function (Blueprint $table) {
            $table->id('employee_branch_history_id');
            $table->unsignedBigInteger('employee_id');
            // Keep the historical branch identifier and labels after deletion.
            $table->unsignedBigInteger('branch_id')->index();
            $table->string('branch_code', 50);
            $table->string('branch_name', 255);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('recorded_at')->useCurrent();

            $table->foreign('employee_id', 'fk_employee_branch_history_employee')
                ->references('employee_id')
                ->on('tblEmployees')
                ->cascadeOnDelete();
        });

        DB::table('tblBranches')
            ->orderBy('branch_id')
            ->chunkById(100, function ($branches) {
                $snapshots = $branches->map(function ($branch) {
                    return [
                        'branch_id' => $branch->branch_id,
                        'action' => 'baseline',
                        'branch_code' => $branch->branch_code,
                        'branch_name' => $branch->branch_name,
                        'phones' => $branch->phones,
                        'email' => $branch->email,
                        'address' => $branch->address,
                        'location' => $branch->location,
                        'status' => $branch->status,
                        'recorded_at' => now(),
                    ];
                })->all();

                DB::table('tblBranchHistory')->insert($snapshots);
            }, 'branch_id', 'branch_id');
    }

    public function down(): void
    {
        Schema::dropIfExists('tblEmployeeBranchHistory');
        Schema::dropIfExists('tblBranchHistory');
    }
};
