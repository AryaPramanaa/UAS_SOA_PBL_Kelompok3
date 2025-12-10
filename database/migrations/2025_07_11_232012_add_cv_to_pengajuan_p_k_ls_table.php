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
        Schema::table('pengajuanPKLs', function (Blueprint $table) {
            $table->string('cv')->nullable()->after('divisi_pilihan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuanPKLs', function (Blueprint $table) {
            $table->dropColumn('cv');
        });
    }
};
