<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pak_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi');
            $table->date('tanggal_sidang');
            $table->text('notula')->nullable();
            $table->enum('status', ['dijadwalkan', 'selesai'])->default('dijadwalkan');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pak_sessions');
    }
};