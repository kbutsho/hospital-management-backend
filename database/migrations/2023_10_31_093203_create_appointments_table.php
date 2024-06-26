<?php

use App\Helpers\STATUS;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('serial_id');
            $table->bigInteger('schedule_id');
            $table->bigInteger('patient_id');
            $table->bigInteger('serial_number');
            $table->enum('status', [STATUS::PAID, STATUS::IN_PROGRESS, STATUS::CLOSED]);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
