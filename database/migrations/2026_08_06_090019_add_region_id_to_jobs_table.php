<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('jobs', 'region_id')) {
            Schema::table('jobs', function (Blueprint $table) {
                try {
                    $table->dropForeign(['region_id']);
                } catch (\Exception $e) {
                    // Ignore
                }
                $table->dropColumn('region_id');
            });
        }

        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
};
