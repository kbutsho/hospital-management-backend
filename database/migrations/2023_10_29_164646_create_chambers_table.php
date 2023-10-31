<?php

use App\Helpers\status;
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
        Schema::create('chambers', function (Blueprint $table) {
            $table->id();
            $table->longText('location');
            $table->enum('status', [
                STATUS::ACTIVE,
                STATUS::IN_ACTIVE,
                STATUS::PENDING,
                STATUS::DISABLE,
            ]);
            $table->bigInteger('user_id');
            $table->bigInteger('doctor_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chambers');
    }
};
