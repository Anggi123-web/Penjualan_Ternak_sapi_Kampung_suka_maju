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
        Schema::table('sapis', function (Blueprint $table) {
            $table->string('status_penjualan', 20)->default('tersedia')->after('tipe_penjualan');
        });

        // Tandai sapi yang sudah pernah dipesan (transaksi tidak dibatalkan) sebagai terjual
        $terjualSapiIds = DB::table('transaksis')
            ->where('status', '!=', 'dibatalkan')
            ->pluck('sapi_id')
            ->unique();

        if ($terjualSapiIds->isNotEmpty()) {
            DB::table('sapis')
                ->whereIn('id', $terjualSapiIds)
                ->update(['status_penjualan' => 'terjual']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sapis', function (Blueprint $table) {
            $table->dropColumn('status_penjualan');
        });
    }
};
