<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessor_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('promotion_submissions')->onDelete('cascade');
            $table->foreignId('assessor_user_id')->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessor_assignments');
    }
};
