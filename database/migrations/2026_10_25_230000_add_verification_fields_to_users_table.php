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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status_verifikasi')->default('terverifikasi')->after('role'); // 'menunggu_verifikasi', 'terverifikasi', 'ditolak'
            $table->timestamp('tanggal_verifikasi')->nullable()->after('status_verifikasi');
            $table->foreignId('diverifikasi_oleh')->nullable()->after('tanggal_verifikasi')->constrained('users')->nullOnDelete();
            $table->text('alasan_penolakan')->nullable()->after('diverifikasi_oleh');
            $table->timestamp('wa_notifikasi_terkirim_at')->nullable()->after('alasan_penolakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['diverifikasi_oleh']);
            $table->dropColumn([
                'status_verifikasi',
                'tanggal_verifikasi',
                'diverifikasi_oleh',
                'alasan_penolakan',
                'wa_notifikasi_terkirim_at',
            ]);
        });
    }
};
