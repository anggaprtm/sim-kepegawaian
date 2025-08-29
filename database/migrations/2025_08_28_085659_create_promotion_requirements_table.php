<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('promotion_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan_fungsional');
            $table->string('nama_dokumen');
            $table->boolean('is_wajib')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('promotion_requirements');
    }
};