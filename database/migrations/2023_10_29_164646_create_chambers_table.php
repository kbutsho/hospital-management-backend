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
            $table->text('location');
            $table->enum('status', [
                status::ACTIVE,
                status::IN_ACTIVE,
                status::PENDING,
                status::DISABLE,
            ]);
            $table->integer('user_id');
            $table->integer('doctor_id');
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
