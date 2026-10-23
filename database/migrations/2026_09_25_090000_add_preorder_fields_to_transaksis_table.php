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
            $table->date('tanggal_pengambilan')->nullable()->after('is_pengantaran');
            $table->unsignedInteger('durasi_perawatan_hari')->default(0)->after('tanggal_pengambilan');
            $table->unsignedBigInteger('biaya_perawatan')->default(0)->after('durasi_perawatan_hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pengambilan', 'durasi_perawatan_hari', 'biaya_perawatan']);
        });
    }
};
