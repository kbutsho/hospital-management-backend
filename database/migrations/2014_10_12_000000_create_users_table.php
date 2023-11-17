<?php

use App\Helpers\ROLE;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->enum('role', [
                ROLE::ADMINISTRATOR,
                ROLE::DOCTOR,
                ROLE::PATIENT,
                ROLE::ASSISTANT,
            ]);
            $table->enum('status', [
                STATUS::ACTIVE,
                STATUS::PENDING,
                STATUS::DISABLE,
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