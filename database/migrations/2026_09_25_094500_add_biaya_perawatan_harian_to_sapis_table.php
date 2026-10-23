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
            $table->unsignedBigInteger('biaya_perawatan_harian')->default(25000)->after('preorder_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sapis', function (Blueprint $table) {
            $table->dropColumn('biaya_perawatan_harian');
        });
    }
};
