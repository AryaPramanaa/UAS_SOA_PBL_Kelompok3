<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hobis', function (Blueprint $table) {
            $table->id();
            $table->integer('no')->unique();
            $table->string('nama_mahasiswa');
            $table->string('hobi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hobis');
    }
};
