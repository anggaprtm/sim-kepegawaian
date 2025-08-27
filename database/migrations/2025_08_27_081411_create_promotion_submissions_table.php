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
        Schema::create('promotion_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_user_id')->constrained('users')->onDelete('cascade');
            $table->string('jabatan_fungsional_sebelumnya')->nullable();
            $table->string('jabatan_fungsional_tujuan');
            $table->string('status'); // e.g., 'diajukan', 'verifikasi_berkas', 'revisi_berkas', 'penilaian_asesor', 'sidang_pak', dst.
            $table->text('catatan_revisi')->nullable();
            $table->text('catatan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_submissions');
    }
};
