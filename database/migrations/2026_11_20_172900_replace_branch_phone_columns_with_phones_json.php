<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tblBranches', function (Blueprint $table) {
            $table->json('phones')->nullable();
        });

        DB::table('tblBranches')
            ->select('branch_id', 'phone1', 'phone2')
            ->orderBy('branch_id')
            ->get()
            ->each(function (object $branch): void {
                $phones = [];

                if ($branch->phone1 !== null && $branch->phone1 !== '') {
                    $phones[] = [
                        'number' => $branch->phone1,
                        'label' => 'Main',
                    ];
                }

                if ($branch->phone2 !== null && $branch->phone2 !== '') {
                    $phones[] = [
                        'number' => $branch->phone2,
                        'label' => 'Alternate',
                    ];
                }

                DB::table('tblBranches')
                    ->where('branch_id', $branch->branch_id)
                    ->update([
                        'phones' => json_encode($phones, JSON_THROW_ON_ERROR),
                    ]);
            });

        Schema::table('tblBranches', function (Blueprint $table) {
            $table->dropColumn(['phone1', 'phone2']);
        });
    }

    public function down(): void
    {
        Schema::table('tblBranches', function (Blueprint $table) {
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
        });

        DB::table('tblBranches')
            ->select('branch_id', 'phones')
            ->orderBy('branch_id')
            ->get()
            ->each(function (object $branch): void {
                $phones = json_decode(
                    $branch->phones ?? '[]',
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );
                $numbers = [
                    'phone1' => null,
                    'phone2' => null,
                ];

                foreach ($phones as $phone) {
                    $column = match ($phone['label'] ?? null) {
                        'Main' => 'phone1',
                        'Alternate' => 'phone2',
                        default => throw new RuntimeException(
                            'Cannot roll back a branch phone with an unsupported label.'
                        ),
                    };

                    $numbers[$column] = $phone['number'];
                }

                DB::table('tblBranches')
                    ->where('branch_id', $branch->branch_id)
                    ->update($numbers);
            });

        Schema::table('tblBranches', function (Blueprint $table) {
            $table->dropColumn('phones');
        });
    }
};
