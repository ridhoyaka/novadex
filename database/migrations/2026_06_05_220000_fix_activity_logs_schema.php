<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('activity_logs', 'description')) {
                $table->text('description')->nullable()->after('action');
            }

            $table->string('model_type', 255)->nullable()->change();
            $table->unsignedBigInteger('model_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('model_type', 255)->nullable(false)->change();
            $table->unsignedBigInteger('model_id')->nullable(false)->change();

            if (Schema::hasColumn('activity_logs', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
