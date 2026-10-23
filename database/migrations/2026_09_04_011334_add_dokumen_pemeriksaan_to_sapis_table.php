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
        Schema::table('sapis', function (Blueprint $table) {
            $table->string('dokumen_pemeriksaan')->nullable()->after('catatan_kesehatan')->comment('Path file PDF dokumen hasil pemeriksaan dokter hewan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sapis', function (Blueprint $table) {
            $table->dropColumn('dokumen_pemeriksaan');
        });
    }
};
