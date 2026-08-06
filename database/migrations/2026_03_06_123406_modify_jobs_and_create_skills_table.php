<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create skills master table
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // 2. Modify jobs table
        Schema::table('jobs', function (Blueprint $table) {
            // Rename description to roles_and_responsibility
            $table->renameColumn('description', 'roles_and_responsibility');
            // Remove title_image
            $table->dropColumn('title_image');
        });

        // 3. Create pivot table for job skills
        Schema::create('job_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_skill');
        
        Schema::table('jobs', function (Blueprint $table) {
            $table->renameColumn('roles_and_responsibility', 'description');
            $table->string('title_image')->nullable();
        });

        Schema::dropIfExists('skills');
    }
};
