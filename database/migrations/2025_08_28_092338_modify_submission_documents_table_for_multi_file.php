<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('submission_documents', function (Blueprint $table) {
            $table->dropColumn('nama_dokumen');
            $table->foreignId('promotion_requirement_id')->constrained()->onDelete('cascade')->after('submission_id');
        });
    }
    public function down(): void {
        Schema::table('submission_documents', function (Blueprint $table) {
            $table->dropForeign(['promotion_requirement_id']);
            $table->dropColumn('promotion_requirement_id');
            $table->string('nama_dokumen');
        });
    }
};