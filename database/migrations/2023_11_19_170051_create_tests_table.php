<?php

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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('remote_host');
            $table->string('remote_log');
            $table->string('remote_user');
            $table->dateTime('time_stamp');
            $table->string('http_method');
            $table->text('url_path');
            $table->string('protocol_version');
            $table->enum('status', ['active', 'pending', 'disable']);
            $table->integer('http_status_code');
            $table->integer('bytes_sent');
            $table->text('referer_url');
            $table->text('user_agent');
            $table->text('forwarded_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
