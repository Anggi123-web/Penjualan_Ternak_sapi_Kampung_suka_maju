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
            $table->text('foto')->nullable()->change();
            $table->text('video')->nullable()->change();
        });

        // Convert existing string rows to JSON arrays
        $rows = DB::table('sapis')->get();
        foreach ($rows as $row) {
            $foto = $row->foto;
            $video = $row->video;

            $updated = [];

            if ($foto && !str_starts_with($foto, '[')) {
                $updated['foto'] = json_encode([$foto]);
            }

            if ($video && !str_starts_with($video, '[')) {
                $updated['video'] = json_encode([$video]);
            }

            if (!empty($updated)) {
                DB::table('sapis')->where('id', $row->id)->update($updated);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sapis', function (Blueprint $table) {
            $table->string('foto')->nullable()->change();
            $table->string('video')->nullable()->change();
        });
    }
};
