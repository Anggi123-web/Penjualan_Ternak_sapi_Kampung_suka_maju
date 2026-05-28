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
        Schema::create('sapis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('jenis');
            $table->integer('umur')->comment('Umur dalam bulan');
            $table->decimal('bobot', 8, 2)->comment('Bobot dalam kg');
            $table->bigInteger('harga')->comment('Harga dalam rupiah');
            $table->string('foto')->nullable();
            $table->string('video')->nullable();
            $table->text('catatan_kesehatan')->nullable()->comment('Diisi oleh Mantri Hewan');
            $table->enum('status_kesehatan', ['belum_diperiksa', 'sehat', 'tidak_sehat'])->default('belum_diperiksa');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sapis');
    }
};
