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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('sapi_id')->constrained('sapis')->cascadeOnDelete();
            $table->string('tipe_penjualan')->default('order');
            $table->unsignedBigInteger('harga_sapi');
            $table->unsignedBigInteger('dp')->nullable();
            $table->boolean('is_pengantaran')->default(false);
            $table->text('detail_lokasi')->nullable();
            $table->unsignedBigInteger('ongkir')->default(0);
            $table->unsignedBigInteger('total_harga');
            $table->unsignedBigInteger('dibayarkan');
            $table->unsignedBigInteger('sisa_pembayaran')->default(0);
            $table->enum('metode_pembayaran', ['transfer', 'cash'])->default('transfer');
            $table->text('catatan')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status')->default('menunggu_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
