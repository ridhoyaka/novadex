<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('whatsapp');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('alamat_lengkap')->nullable()->after('longitude');
        });
    }

    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'alamat_lengkap']);
        });
    }
};
