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
        Schema::create('laporanMahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuanPKL_id')->constrained('pengajuanPKLs')->onDelete('cascade');
            $table->foreignId('pembimbingIndustri_id')->constrained('pembimbingIndustris')->onDelete('cascade');
            $table->foreignId('pembimbingAkademik_id')->constrained('pembimbing_akademik')->onDelete('cascade');
            $table->date('tanggal_laporan');
            $table->text('isi_laporan');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_perusahaan')->nullable()->after('status');
            $table->foreign('id_perusahaan')->references('id')->on('perusahaans')->onDelete('set null');
            $table->unique('id_perusahaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporanMahasiswas');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_perusahaan']);
            $table->dropColumn('id_perusahaan');
        });
    }
};
