<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblTimeSlots', function (Blueprint $table) {
            $table->id('slot_id');

            $table->string('slot_name', 50)->nullable();

            $table->time('start_time');
            $table->time('end_time');

            $table->string('status', 20)->default('Active');

            $table->unique(
                ['start_time', 'end_time'],
                'uq_time_slot'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblTimeSlots');
    }
};
