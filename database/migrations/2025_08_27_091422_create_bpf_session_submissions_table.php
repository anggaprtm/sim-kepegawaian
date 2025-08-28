<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bpf_session_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bpf_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('submission_id')->constrained('promotion_submissions')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('bpf_session_submissions');
    }
};