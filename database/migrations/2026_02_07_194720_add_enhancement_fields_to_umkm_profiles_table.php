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
        Schema::table('umkm_profiles', function (Blueprint $table) {
            // Note: latitude, longitude, alamat_lengkap already exist from previous migration
            // We'll use existing columns and add new ones
            
            // SEO fields (auto-generated)
            $table->string('seo_title', 255)->nullable()->after('alamat_lengkap');
            $table->text('seo_description')->nullable()->after('seo_title');
            
            // Profile completion score (0-100)
            $table->tinyInteger('profile_completion_score')->unsigned()->default(0)->after('seo_description');
            
            // Indexes for performance
            $table->index('profile_completion_score', 'idx_completion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex('idx_completion');
            
            // Drop columns
            $table->dropColumn([
                'seo_title',
                'seo_description',
                'profile_completion_score',
            ]);
        });
    }
};
