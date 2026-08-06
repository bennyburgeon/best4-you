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
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('job_code')->unique()->nullable()->after('id');
            $table->date('opening_date')->nullable()->after('job_code');
            $table->date('closing_date')->nullable()->after('opening_date');
            $table->string('gender_preference')->nullable()->after('closing_date');
            $table->foreignId('industry_type_id')->nullable()->constrained()->onDelete('set null')->after('gender_preference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['industry_type_id']);
            $table->dropColumn(['job_code', 'opening_date', 'closing_date', 'gender_preference', 'industry_type_id']);
        });
    }
};
