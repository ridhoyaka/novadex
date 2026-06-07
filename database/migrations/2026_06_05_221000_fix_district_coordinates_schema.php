<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('districts')
            ->whereNull('latitude')
            ->update(['latitude' => -7.3305]);

        DB::table('districts')
            ->whereNull('longitude')
            ->update(['longitude' => 110.5083]);

        Schema::table('districts', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->default(-7.3305)->change();
            $table->decimal('longitude', 11, 8)->nullable()->default(110.5083)->change();
        });
    }

    public function down(): void
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable(false)->default(null)->change();
            $table->decimal('longitude', 11, 8)->nullable(false)->default(null)->change();
        });
    }
};
