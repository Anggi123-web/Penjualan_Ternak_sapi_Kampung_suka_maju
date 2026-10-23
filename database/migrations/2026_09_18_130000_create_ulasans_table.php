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
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->unique()->constrained('transaksis')->cascadeOnDelete();
            $table->foreignId('pembeli_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('peternak_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sapi_id')->nullable()->constrained('sapis')->nullOnDelete();
            $table->tinyInteger('rating')->unsigned(); // 1 - 5
            $table->text('komentar');
            $table->json('kategori')->nullable(); // Tags seperti ['Sapi Sehat', 'Pengiriman Cepat']
            $table->string('foto')->nullable();
            $table->text('balasan_peternak')->nullable();
            $table->timestamp('balasan_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};
