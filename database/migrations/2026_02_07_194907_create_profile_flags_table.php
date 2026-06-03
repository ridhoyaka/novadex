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
        Schema::create('profile_flags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_profile_id')
                ->constrained('umkm_profiles')
                ->onDelete('cascade');
            $table->foreignId('admin_user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->enum('flag_type', ['inappropriate', 'duplicate', 'incomplete', 'quality']);
            $table->text('reason')->nullable();
            $table->enum('status', ['active', 'resolved', 'dismissed'])->default('active');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('umkm_profile_id', 'idx_profile');
            $table->index('status', 'idx_status');
            $table->index('created_at', 'idx_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_flags');
    }
};
