<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembimbing_akademik', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->unique();
            $table->foreignId('prodi_id')->constrained('prodis')->onDelete('cascade');
            $table->integer('kapasitas_bimbingan');
            $table->string('kontak')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // Create pivot table for pembimbing_akademik and mahasiswa
        Schema::create('mahasiswa_pembimbing_akademik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembimbing_akademik_id')->constrained('pembimbing_akademik')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa_pembimbing_akademik');
        Schema::dropIfExists('pembimbing_akademik');
    }
}; 