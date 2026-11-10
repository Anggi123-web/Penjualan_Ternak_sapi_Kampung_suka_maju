<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('fase_pembayaran')->nullable()->default('dp')->after('dp');
            $table->unsignedBigInteger('jumlah_pelunasan')->default(0)->after('sisa_pembayaran');
            $table->string('bukti_pelunasan')->nullable()->after('bukti_pembayaran');
        });

        // Set initial values for existing transactions
        DB::table('transaksis')->where('tipe_penjualan', 'order')->update([
            'fase_pembayaran' => 'lunas',
            'jumlah_pelunasan' => 0,
        ]);

        DB::table('transaksis')->where('tipe_penjualan', 'pre_order')->where('sisa_pembayaran', '<=', 0)->update([
            'fase_pembayaran' => 'lunas',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['fase_pembayaran', 'jumlah_pelunasan', 'bukti_pelunasan']);
        });
    }
};
