<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hobis', function (Blueprint $table) {
            $table->unsignedBigInteger('mahasiswa_id')->nullable()->after('no');
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('hobis', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });
    }
};
