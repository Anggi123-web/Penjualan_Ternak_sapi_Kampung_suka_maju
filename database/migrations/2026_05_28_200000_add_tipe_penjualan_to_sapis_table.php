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
            $table->enum('tipe_penjualan', ['order', 'pre_order'])->default('order')->after('video');
            $table->unsignedTinyInteger('preorder_bulan')->nullable()->after('tipe_penjualan');
            $table->unsignedSmallInteger('preorder_tahun')->nullable()->after('preorder_bulan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sapis', function (Blueprint $table) {
            $table->dropColumn(['tipe_penjualan', 'preorder_bulan', 'preorder_tahun']);
        });
    }
};
