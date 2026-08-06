<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('jobs', 'region_id')) {

            // Check if a foreign key exists for region_id
            $foreignKey = DB::selectOne("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'jobs'
                  AND COLUMN_NAME = 'region_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
                LIMIT 1
            ");

            // Drop the foreign key if it exists
            if ($foreignKey) {
                DB::statement("ALTER TABLE `jobs` DROP FOREIGN KEY `{$foreignKey->CONSTRAINT_NAME}`");
            }

            // Drop the column
            Schema::table('jobs', function (Blueprint $table) {
                $table->dropColumn('region_id');
            });
        }

        // Create the new foreign key column
        Schema::table('jobs', function (Blueprint $table) {
            $table->foreignId('region_id')
                ->nullable()
                ->constrained('regions')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jobs', 'region_id')) {

            $foreignKey = DB::selectOne("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'jobs'
                  AND COLUMN_NAME = 'region_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
                LIMIT 1
            ");

            if ($foreignKey) {
                DB::statement("ALTER TABLE `jobs` DROP FOREIGN KEY `{$foreignKey->CONSTRAINT_NAME}`");
            }

            Schema::table('jobs', function (Blueprint $table) {
                $table->dropColumn('region_id');
            });
        }
    }
};