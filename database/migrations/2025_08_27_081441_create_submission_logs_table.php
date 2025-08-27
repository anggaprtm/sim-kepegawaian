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
        Schema::create('submission_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('promotion_submissions')->onDelete('cascade');
            $table->string('status_sebelumnya')->nullable();
            $table->string('status_sekarang');
            $table->text('catatan')->nullable();
            $table->foreignId('processed_by_user_id')->nullable()->constrained('users'); // User (tendik) yang memproses
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_logs');
    }
};
