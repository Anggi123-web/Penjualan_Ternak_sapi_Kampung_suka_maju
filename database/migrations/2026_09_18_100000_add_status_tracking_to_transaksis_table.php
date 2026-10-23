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
            $table->timestamp('status_updated_at')->nullable()->after('status');
            $table->timestamp('pembeli_read_at')->nullable()->after('status_updated_at');
            $table->text('catatan_status')->nullable()->after('pembeli_read_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['status_updated_at', 'pembeli_read_at', 'catatan_status']);
        });
    }
};
