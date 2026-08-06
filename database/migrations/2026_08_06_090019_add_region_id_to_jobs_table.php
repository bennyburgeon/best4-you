<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('jobs', 'region_id')) {

            DB::statement("
                ALTER TABLE jobs
                DROP FOREIGN KEY IF EXISTS jobs_region_id_foreign
            ");

            Schema::table('jobs', function (Blueprint $table) {
                $table->dropColumn('region_id');
            });
        }

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
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
};
