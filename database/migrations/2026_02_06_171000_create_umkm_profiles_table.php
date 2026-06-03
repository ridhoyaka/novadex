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
        Schema::create('umkm_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('nama_usaha', 255);
            $table->string('slug', 255)->unique();
            $table->foreignId('kategori_id')
                ->constrained('categories')
                ->onDelete('restrict');
            $table->foreignId('kecamatan_id')
                ->constrained('districts')
                ->onDelete('restrict');
            $table->text('deskripsi');
            $table->string('whatsapp', 20);
            $table->string('logo_path', 255)->nullable();
            $table->json('photos')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            
            // Indexes for performance
            $table->index('slug');
            $table->index('is_published');
            $table->index('kategori_id');
            $table->index('kecamatan_id');
        });
        
        // Add fulltext index only for MySQL (not supported in SQLite)
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            Schema::table('umkm_profiles', function (Blueprint $table) {
                $table->fullText('nama_usaha');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_profiles');
    }
};
