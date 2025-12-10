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
        Schema::create('pembimbingIndustris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembimbing');
            $table->string('jabatan');
            $table->string('kontak');
            $table->string('email');
            $table->foreignId('perusahaan_id')->constrained('perusahaans');
            $table->integer('kapasitas_bimbingan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbingIndustris');
    }
};
