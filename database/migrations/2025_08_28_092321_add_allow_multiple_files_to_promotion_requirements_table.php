<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('promotion_requirements', function (Blueprint $table) {
            $table->boolean('allow_multiple_files')->default(false)->after('is_wajib');
        });
    }
    public function down(): void {
        Schema::table('promotion_requirements', function (Blueprint $table) {
            $table->dropColumn('allow_multiple_files');
        });
    }
};