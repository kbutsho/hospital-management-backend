<?php

use App\Helpers\role;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('email')->unique()->nullable();
            $table->enum('role', [
                role::ADMINISTRATOR,
                role::DOCTOR,
                role::PATIENT,
                role::ASSISTANT,
            ]);
            $table->enum('status', [
                status::ACTIVE,
                status::IN_ACTIVE,
                status::PENDING,
                status::DISABLE,
            ]);
            $table->string('password')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
