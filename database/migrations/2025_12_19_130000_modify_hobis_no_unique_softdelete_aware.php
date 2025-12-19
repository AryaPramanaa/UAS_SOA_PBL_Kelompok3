<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hobis', function (Blueprint $table) {
            // Drop the old unique index on `no` and add a composite unique index with `deleted_at`
            // so soft-deleted rows do not block reuse of `no` values.
            $table->dropUnique('hobis_no_unique');
            $table->unique(['no', 'deleted_at'], 'hobis_no_deleted_at_unique');
        });
    }

    public function down(): void
    {
        Schema::table('hobis', function (Blueprint $table) {
            $table->dropUnique('hobis_no_deleted_at_unique');
            $table->unique('no');
        });
    }
};