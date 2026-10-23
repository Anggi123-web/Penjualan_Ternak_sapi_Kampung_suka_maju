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
            $table->string('nik')->nullable()->after('name');
            $table->string('no_telepon')->nullable()->after('email');
            $table->string('nomor_rekening')->nullable()->after('longitude');
            $table->string('jenis_bank')->nullable()->after('nomor_rekening');
            $table->string('foto_ktp')->nullable()->after('jenis_bank');
            $table->string('foto_selfie_ktp')->nullable()->after('foto_ktp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'no_telepon', 'nomor_rekening', 'jenis_bank', 'foto_ktp', 'foto_selfie_ktp']);
        });
    }
};
