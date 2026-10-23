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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('surat_keterangan')->nullable()->after('bukti_pembayaran');
            $table->string('nomor_surat')->nullable()->after('surat_keterangan');
            $table->timestamp('surat_released_at')->nullable()->after('nomor_surat');
            $table->foreignId('surat_aparat_id')->nullable()->after('surat_released_at')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['surat_aparat_id']);
            $table->dropColumn(['surat_keterangan', 'nomor_surat', 'surat_released_at', 'surat_aparat_id']);
        });
    }
};
